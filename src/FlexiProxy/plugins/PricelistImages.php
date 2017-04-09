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
class PricelistImages extends CommonHtml implements CommonPluginInterface
{

    public $myPathRegex = '(cenik|cenik.html)($|\?)';
    public $myDirection = 'output';

    public function process()
    {
        $this->replaceContent('a href', 'a title="link" href');
        $this->includeJavaScript('js/PricelistImages.js');
        $this->addJavaScript('alert("listing images");');
    }

}
