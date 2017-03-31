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
class FlexiProxy extends \Ease\Brick
{

    /**
     * Configuration
     * @var \stdClass
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
     * FelexiProxy worker
     *
     * @param string $conf Config.json path override
     */
    public function __construct($conf = null)
    {
        if (!is_null($conf)) {
            $this->configFile = $conf;
        }
        $this->loadConfig($this->configFile);
        parent::__construct();
        $this->uriRequested = $_SERVER['REQUEST_URI'];
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

}
