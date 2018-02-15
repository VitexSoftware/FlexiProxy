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
        $cfglogo = \Ease\Shared::instanced()->getConfigValue('logo');
        $newLogo = is_null($cfglogo) ? '/images/logo-flexiproxy.png' : $cfglogo;
        $this->pregReplaceContent('/\/flexibee-static\/(\d+\.)(\d+\.).*\/img\/logo-abraflexibee\.png/',
            $newLogo);
    }

}
