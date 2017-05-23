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
class PricelistItemImages extends \FlexiProxy\plugins\output\CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{
    public $myPathRegex = 'cenik\/(\d+)$';
    public $myDirection = 'output';

    public function process()
    {
        if (preg_match('/cenik\/(\d+)/', $this->flexiProxy->uriRequested,
                $matches)) {
            $recordID = intval($matches[1]);

            $pricelister = new \FlexiPeeHP\Cenik($recordID,
                ['company' => $this->flexiProxy->company]);
            $pricelister->ignore404(true);

            $images = \FlexiPeeHP\Priloha::getAttachmentsList($pricelister);

//            $image = \FlexiPeeHP\Priloha::getFirstAttachment($pricelister);
            //$this->includeJavaScript($processed, 'js/PricelistImages.js');
            //            $this->addJavaScript($processed, 'alert("' . $image . '");');

            if (count($images) && ($pricelister->lastResponseCode == 200)) {
                $gallery = '<div style="padding: 10px">';
                foreach ($images as $image) {
                    if (strstr($image['contentType'], 'image')) {
                        $gallery .= '<img width="300" src="'.$this->flexiProxy->fixURLs($image['url']).'/content">';
                    }
                }
                $gallery .= '</div>';
                $this->addBefore('</div> <!-- flexibee-application-content -->',
                    $gallery);
            }
        }
    }
}
