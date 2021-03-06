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
class PricelistImages extends \FlexiProxy\plugins\output\CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{

    public $myPathRegex = '(cenik|cenik\.html)($|\?.*$)';
    public $myDirection = 'output';

    public function process()
    {
        $this->replaceContent('a href', 'a title="link" href');
//        $this->includeJavaScript($processed, 'js/PricelistImages.js');
//        $this->addJavaScript($processed, 'alert("listing images");');
    }

}
