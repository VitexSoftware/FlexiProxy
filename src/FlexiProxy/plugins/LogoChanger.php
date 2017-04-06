<?php

/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2016-2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins;

/**
 * Description of PricelistImages
 *
 * @author vitex
 */
class LogoChanger extends CommonHtml implements CommonPluginInterface
{

    public $myPathRegex = '.*';
    public $myDirection = 'output';
    public $myFormat = 'html';

    public function process()
    {
        $this->preg_replaceContent('\/flexibee-static\/\d{4}\.(\d|\d{2})\.(\d|\d{2})/img\/logo-abraflexibee.png/', '/images/logo-flexiproxy.png');
    }

}
