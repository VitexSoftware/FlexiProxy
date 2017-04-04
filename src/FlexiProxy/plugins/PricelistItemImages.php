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
class PricelistItemImages extends CommonHtml implements CommonPluginInterface
{

    public $myPathRegex = 'cenik\/';
    public $myDirection = 'output';

    public function process(&$documentData)
    {
        if (preg_match('/cenik\/(\d)/', $this->flexiProxy->uriRequested, $matches)) {
            $recordID = intval($matches[1]);

            $pricelister = new \FlexiPeeHP\Cenik($recordID);


            $images = \FlexiPeeHP\Priloha::getAttachmentsList($pricelister);

            $image = \FlexiPeeHP\Priloha::getFirstAttachment($pricelister);

            $processed = str_replace('a href', 'a title="link" href', $documentData);
            //$this->includeJavaScript($processed, 'js/PricelistImages.js');
            //            $this->addJavaScript($processed, 'alert("' . $image . '");');

            $this->addToBodyEnd($processed, '<div style="border: 1px solid red"><img src="' . $image['url'] . '/content"></div>');


            $documentData = $processed;
        }
    }

}
