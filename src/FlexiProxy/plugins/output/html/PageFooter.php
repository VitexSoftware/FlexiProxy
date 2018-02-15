<?php
/**
 * FlexiProxy main page plugin.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins\output\html;

/**
 * Redirect to mainpage
 *
 * @author vitex
 */
class PageFooter extends \FlexiProxy\plugins\output\CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{
    public $myPathRegex = '.*';
    public $myDirection = 'output';

    public function process()
    {
        $composer = 'composer.json';
        if (!file_exists($composer)) {
            $composer = '../'.$composer;
        }

        $appInfo = json_decode(file_get_contents($composer));

        $this->addAfter('<!--FLEXIBEE:FOOTER:START-->
<div class="col-sm-4">',
            '<small><a href="https://github.com/VitexSoftware/FlexiProxy/">Flexi<strong>ProXY</strong> v.: '.$appInfo->version.'</a></small> | ');
    }
}
