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
class PricelistItemImages extends CommonHtml implements CommonPluginInterface
{

    public $myPathRegex = 'cenik\/';
    public $myDirection = 'output';

    public function process()
    {
        if (preg_match('/cenik\/(\d)/', $this->flexiProxy->uriRequested, $matches)) {
            $recordID = intval($matches[1]);

            $pricelister = new \FlexiPeeHP\Cenik($recordID);


            $images = \FlexiPeeHP\Priloha::getAttachmentsList($pricelister);

            $image = \FlexiPeeHP\Priloha::getFirstAttachment($pricelister);

            $processed = str_replace('a href', 'a title="link" href', $documentData);
            //$this->includeJavaScript($processed, 'js/PricelistImages.js');
            //            $this->addJavaScript($processed, 'alert("' . $image . '");');

            $this->addToBodyEnd('<div style="border: 1px solid red"><img src="' . $image['url'] . '/content"></div>');
        }
    }

}
