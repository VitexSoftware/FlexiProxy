<?php

/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2016-2017 VitexSoftwarec (G)
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
        $dest = $parsed['scheme'] . '://' . $parsed['host'];
        if (isset($parsed['port'])) {
            $dest .= ':' . $parsed['port'];
        }
        $this->baseUrl = $dest;
    }

    /**
     * Inicializace CURL
     * Return Headers
     */
    public function curlInit()
    {
        parent::curlInit();
        curl_setopt($this->curl, CURLOPT_HEADER, true);
        curl_setopt($this->curl, CURLOPT_ACCEPT_ENCODING, 'identity');
    }

    static public function getCurlResponseBody($response)
    {
        $parts = explode("\r\n\r\n", $response);
        return end($parts);
    }

    static public function getHeadersFromCurlResponse($response)
    {
        $headers = array();

        $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

        foreach (explode("\r\n", $header_text) as $i => $line)
            if ($i === 0)
                $headers['http_code'] = $line;
            else {
                list ($key, $value) = explode(': ', $line);

                $headers[$key] = $value;
            }

        return $headers;
    }

    /**
     * Load Configuration values from json file $this->configFile and define UPPERCASE keys
     */
    public function loadConfig($configFile)
    {
        $this->shared = \Ease\Shared::instanced();
        $this->configuration = json_decode(file_get_contents($configFile), true);
        foreach ($this->configuration as $configKey => $configValue) {
            if ((strtoupper($configKey) == $configKey) && (!defined($configKey))) {
                define($configKey, $configValue);
            }
        }
        $this->apiurl = $this->configuration['FLEXIBEE_URL'];
    }

    public function suffixToFormat($uri)
    {
        $format = null;
        $path_parts = pathinfo($uri);
        if (isset($path_parts['extension'])) {
            $extensions = self::reindexArrayBy(self::$formats, 'suffix');
            $format = array_key_exists($path_parts['extension'], $extensions) ? $path_parts['extension'] : null;
        }
        return $format;
    }

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
                    header($hName . ': ' . $hValue);
                    break;
            }
        }
    }

    public function fixURLs($content)
    {
        return str_replace($this->url, $this->baseUrl, $content);
    }

    public function output()
    {
        $this->doCurlRequest($this->url . $this->uriRequested, 'GET', $this->suffixToFormat($this->uriRequested));
        $this->proxyHttpHeaders();
        echo $this->fixURLs(self::getCurlResponseBody($this->lastCurlResponse));
    }

}
