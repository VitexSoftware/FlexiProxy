<?php
/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 */

namespace FlexiProxy;

/**
 * Description of FlexiProxy
 *
 * @author vitex
 */
class FlexiProxy extends \FlexiPeeHP\FlexiBeeRW
{
    /**
     * Configuration
     * @var array
     */
    public $configuration = [];

    /**
     * Where do i get configuration ?
     * @var string
     */
    public $configDir = './';

    /**
     * Local FlexiBee Url
     * @var string
     */
    public $apiurl = null;

    /**
     * What We Want ?
     * @var string
     */
    public $uriRequested = null;

    /**
     * Výchozí formát pro komunikaci.
     * Default communication format.
     *
     * @link https://www.flexibee.eu/api/dokumentace/ref/format-types Přehled možných formátů
     *
     * @var string json|xml|...
     */
    public $format = 'html';

    /**
     * Public URL of FlexiProxy
     * @var string
     */
    public $baseUrl = null;

    /**
     * HTTP method used to invoke
     * @var string PUT|GET|POST|...
     */
    public $requestMethod = null;

    /**
     * Read Data from upstream FlexiBee
     * @var boolean 
     */
    public $readFromUpstream = true;

    /**
     * Data to show
     * @var string
     */
    public $outputData = null;

    /**
     * Shared utility class object
     * @var \Ease\Shared
     */
    public $shared;

    /**
     * FelexiProxy worker
     *
     * @param mixed $init default record id or initial data
     * @param array $options Connection settings override
     */
    public function __construct($init = null, $options = [])
    {
        if (!is_null($options['confdir'])) {
            $this->confDir = $options['confdir'];
        }
        $this->loadConfigs($this->confDir);
        parent::__construct($init, $options);
        if (constant('PHP_SAPI') != 'cli') {
            $this->uriRequested = empty($_SERVER['REQUEST_URI']) ? '/' : $_SERVER['REQUEST_URI'];
            $this->parseFlexiBeeURI($this->uriRequested);

            $parsed = parse_url(\Ease\Page::phpSelf());
            $dest   = $parsed['scheme'].'://'.$parsed['host'];
            if (isset($parsed['port'])) {
                $dest .= ':'.$parsed['port'];
            }
            $this->baseUrl = $dest;
        }
    }

    public function parseFlexiBeeURI($uri)
    {
        $pattern = '\/c\/([a-z_]+)\/([a-z]+)($|\/(\d+)(($|\/(([a-z]+)($|;([a-z]+)$)))|\?.*$)|\?(.*)$)';
        if (preg_match('/'.$pattern.'/', $uri, $matches)) {
            $this->addStatusMessage(implode(',', $matches), 'debug');
            if (isset($matches[3][0]) && ($matches[3][0] == '?')) {
                $this->urlParams = isset($matches[11]) ? $matches[11] : null;
            } else {
                $this->setMyKey(intval($matches[3]));
                $this->urlParams = isset($matches[4]) ? $matches[4] : null;
            }
            $this->setCompany($matches[1]);
            $this->setEvidence($matches[2]);
            $this->section   = isset($matches[7]) ? $matches[7] : null;
            $this->operation = isset($matches[9]) ? $matches[9] : null;
        } else {
            $this->addStatusMessage(sprintf(_('URI %s was not parsed'), $uri),
                'warning');
        }
    }

    /**
     * Initialise CURL for Proxy
     * Return Headers
     */
    public function curlInit()
    {
        parent::curlInit();
        curl_setopt($this->curl, CURLOPT_HEADER, true);
        curl_setopt($this->curl, CURLOPT_ACCEPT_ENCODING, 'identity');
    }

    /**
     * Obtain BODY from raw CurlResponse with Headers part
     *
     * @param string $response
     * @return string
     */
    static public function getCurlResponseBody($response)
    {
        $parts = explode("\r\n\r\n", $response);
        return end($parts);
    }

    /**
     * Take headers from Curl Response
     *
     * @param string $response
     * @return array
     */
    static public function getHeadersFromCurlResponse($response)
    {
        $headers  = array();
        $response = str_replace("HTTP/1.1 100 Continue\r\n\r\n", '', $response);

        $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

        foreach (explode("\r\n", $header_text) as $i => $line) {
            if ($i === 0) {
                $headers['http_code'] = $line;
            } else {
                list ($key, $value) = explode(': ', $line);

                $headers[$key] = $value;
            }
        }

        return $headers;
    }

    /**
     * Load Configuration values from json files in $this->confDir and define UPPERCASE keys
     *
     * @param string $configFile path
     * @return array
     */
    public function loadConfig($configFile)
    {

        $configuration = json_decode(file_get_contents($configFile), true);
        foreach ($configuration as $configKey => $configValue) {
            $this->shared->setConfigValue($configKey, $configValue);
            if ((strtoupper($configKey) == $configKey) && (!defined($configKey))) {
                define($configKey, $configValue);
            }
        }
        return $configuration;
    }

    /**
     * Load all config files in config dir
     */
    public function loadConfigs($confdir = null)
    {
        if (!is_object($this->shared)) {
            $this->shared = \Ease\Shared::instanced();
        }

        foreach (glob($confdir.'/*.json') as $configFile) {
            $this->configuration = array_merge($this->configuration,
                $this->loadConfig($configFile));
        }

        $this->debug  = (isset($this->configuration['debug']) && ($this->configuration['debug']
            == 'true') );
        $this->apiurl = $this->configuration['FLEXIBEE_URL'];
    }

    /**
     * Obtain known extension for URI
     *
     * @param string $uri
     * @return string extension
     */
    public function suffixToFormat($uri)
    {
        $format     = null;
        $url_parts  = parse_url($uri);
        $path_parts = pathinfo($url_parts['path']);
        if (isset($path_parts['extension'])) {
            $extensions = self::reindexArrayBy(self::$formats, 'suffix');
            $format     = array_key_exists($path_parts['extension'], $extensions)
                    ? $path_parts['extension'] : null;
        }
        return $format;
    }

    /**
     * Obtain known format for Content-Type
     *
     * @param string $contentType
     * @return string format
     */
    public function contentTypeToFormat($contentType)
    {
        $format = null;
        if (strstr($contentType, ';')) {
            $contentType = current(explode(';', $contentType));
        }
        $contentTypes = self::reindexArrayBy(self::$formats, 'content-type');
        $format       = array_key_exists($contentType, $contentTypes) ? $contentTypes[$contentType]['suffix']
                : null;
        return $format;
    }

    /**
     * Recycle incoming HTTP Headers
     */
    public function proxyHttpHeaders()
    {
        foreach (self::getHeadersFromCurlResponse($this->lastCurlResponse) as $hName => $hValue) {
            switch ($hName) {
                case 'Content-Encoding':
                case 'Transfer-Encoding':
                    break; //Skip Header
                case 'Location':
                    $hValue       = $this->fixURLs($hValue);
                    break;
                case 'Content-Type':
                    $this->format = $this->contentTypeToFormat($hValue);
                default:
                    header($hName.': '.$hValue);
                    break;
            }
        }
    }

    /**
     * Use URL of proxy instead of FlexiBee URL
     *
     * @param string $content
     * @return string
     */
    public function fixURLs($content)
    {
        return str_replace($this->url, $this->baseUrl, $content);
    }

    /**
     * Take Request
     */
    public function inputPrepare()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->inputData     = file_get_contents('php://input');
    }

    /**
     * Take Request
     */
    public function input()
    {
        $this->inputPrepare();
        $this->applyPlugins('input');
        $this->postFields = $this->inputData;
    }

    /**
     * Output response
     */
    public function outputPrepare()
    {
        $this->doCurlRequest($this->url.$this->uriRequested,
            $this->requestMethod, $this->suffixToFormat($this->uriRequested));
        $this->proxyHttpHeaders();
        if ($this->lastResponseCode == 0) {
            header("HTTP/1.0 502 Bad Gateway");
            $this->outputData = new ui\HttpStatusPage(502);
            $this->outputData->container->addItem(_('Please Check').' ');
            $this->outputData->container->addItem(new \Ease\Html\ATag($this->url.$this->uriRequested,
                $this->url.$this->uriRequested));
        } else {
            $this->outputData = $this->fixURLs(self::getCurlResponseBody($this->lastCurlResponse));
        }
        $this->addStatusMessage(sprintf(_('%s: %s'), $this->requestMethod,
                $this->url.$this->uriRequested), 'debug');
    }

    /**
     * Output response
     */
    public function output()
    {
        if ($this->readFromUpstream === true) {
            $this->outputPrepare();
        }
        $this->applyPlugins('output');
        echo $this->outputData;
    }

    /**
     * Apply Plugins to content
     *
     * @param string $direction input|output
     */
    public function applyPlugins($direction)
    {
        $dir = __DIR__."/plugins/*";
        foreach (glob($dir) as $file) {
            if (!is_dir($file) && !strstr($file, 'Common')) {
                $className = "FlexiProxy\\plugins\\".basename(str_replace('.php',
                            '', $file));
                $plugin    = new $className($this);
                if ($plugin->isThisMyDirection($direction) && $plugin->isThisMyFormat($this->format)
                    && $plugin->isThisMyPath($this->uriRequested)) {
                    $this->addStatusMessage(sprintf(_('ApplyPlugin: %s'),
                            addslashes($className)), 'debug');
                    $plugin->apply();
                }
            }
        }
        $messager = new plugins\CommonStatusMessages($this);
        if ($messager->isThisMyDirection($direction) && $messager->isThisMyFormat($this->format)) {
            $this->addStatusMessage(sprintf(_('ApplyPlugin: %s'),
                    addslashes(get_class($messager))), 'debug');
            $messager->apply();
        }
    }

    public function addStatusMessage($message, $type = 'info', $addIcons = true)
    {
        if (($this->debug !== true) && ($type == 'debug')) {
            
        } else {
            return parent::addStatusMessage($message, $type, $addIcons);
        }
    }
}
