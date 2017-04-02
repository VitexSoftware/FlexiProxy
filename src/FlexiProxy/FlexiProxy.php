<?php
/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2016-2017 VitexSoftware (G)
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
    public $configFile = './config.json';

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
     * FelexiProxy worker
     *
     * @param mixed $init default record id or initial data
     * @param array $options Connection settings override
     */
    public function __construct($init = null, $options = [])
    {
        if (!is_null($options['config'])) {
            $this->configFile = $options['config'];
        }
        $this->loadConfig($this->configFile);
        parent::__construct($init, $options);
        $this->uriRequested = empty($_SERVER['REQUEST_URI']) ? '/' : $_SERVER['REQUEST_URI'];

        $parsed = parse_url(\Ease\Page::phpSelf());
        $dest   = $parsed['scheme'].'://'.$parsed['host'];
        if (isset($parsed['port'])) {
            $dest .= ':'.$parsed['port'];
        }
        $this->baseUrl = $dest;
        $this->input();
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
     * Load Configuration values from json file $this->configFile and define UPPERCASE keys
     */
    public function loadConfig($configFile)
    {
        $this->shared        = \Ease\Shared::instanced();
        $this->configuration = json_decode(file_get_contents($configFile), true);
        foreach ($this->configuration as $configKey => $configValue) {
            if ((strtoupper($configKey) == $configKey) && (!defined($configKey))) {
                define($configKey, $configValue);
            }
        }
        $this->apiurl = $this->configuration['FLEXIBEE_URL'];
    }

    /**
     * Obtain known extension for URI
     *
     * @param string $uri
     * @return string
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
                    $hValue = $this->fixURLs($hValue);
                    break;
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
        $this->outputData = $this->fixURLs(self::getCurlResponseBody($this->lastCurlResponse));
    }

    /**
     * Output response
     */
    public function output()
    {
        $this->outputPrepare();
        $this->applyPlugins('output');
        echo $this->outputData;
    }

    public function applyPlugins()
    {
        $dir = __DIR__."/plugins/*";
        foreach (glob($dir) as $file) {
            if (!is_dir($file) && !strstr($file, 'Common')) {
                $className = "FlexiProxy\\plugins\\".basename(str_replace('.php',
                            '', $file));
                $plugin    = new $className($this);
                if ($plugin->isThisMyFormat($this->format) && $plugin->isThisMyPath($this->info['url'])) {
                    $plugin->apply();
                }
            }
        }
    }
}
