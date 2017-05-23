<?php
/**
 * FlexiProxy FormHelper
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 *
 * @package   flexiproxy-custom-columns
 */

namespace FlexiProxy\plugins\output\js;

/**
 * Add .json prefix to Ajax calls
 *
 * @author vitex
 */
class CustomColumnsFormHelper extends \FlexiProxy\plugins\Common implements \FlexiProxy\plugins\CommonPluginInterface
{
    public $myPathRegex = '\/js\/jq\/flexibee\-formhelper.js';
    public $myDirection = 'output';
    public $myFormat    = 'js';

    public function process()
    {
        $this->replaceContent('"?', '".json?');
    }
}
