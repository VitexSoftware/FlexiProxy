<?php

/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2016-2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins\output\html;

/**
 * Description of PricelistImages
 *
 * @author vitex
 */
class LogoChanger extends \FlexiProxy\plugins\output\CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{

    public $myPathRegex = '.*';
    public $myDirection = 'output';
    public $myFormat = 'html';

    public function process()
    {
        $this->preg_replaceContent('/\/flexibee-static\/\d{4}\.(\d|\d{2})\.(\d|\d{2})\/img\/logo-abraflexibee.png/', '/images/logo-flexiproxy.png');
    }

}
