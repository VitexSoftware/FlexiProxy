<?php

/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2016-2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins\html;

/**
 * Description of PricelistImages
 *
 * @author vitex
 */
class Attachments extends CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{

    public $myPathRegex = '\/prilohy($|\?.*$)';
    public $myDirection = 'output';

    public function process()
    {
        $destination = $this->flexiProxy->apiURL.'/prilohy'.htmlentities(';').'new';
        $this->addToPageBottom(new \Ease\TWB\LinkButton('prilohy;new',
            _('New Attachment'), 'success',
            ['data-actionid' => "new", 'onlick' => 'window.location.replace(\''.$destination.'\');']));
    }
}
