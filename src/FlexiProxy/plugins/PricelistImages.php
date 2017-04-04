<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

    public function process(&$documentData)
    {
        $processed = str_replace('a href', 'a title="link" href', $documentData);
        $this->includeJavaScript($processed, 'js/PricelistImages.js');
        $this->addJavaScript($processed, 'alert("listing images");');
        $documentData = $processed;
    }

}
