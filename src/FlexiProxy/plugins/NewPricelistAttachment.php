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
class NewPricelistAttachment extends CommonHtml implements CommonPluginInterface
{

    public $myPathRegex = 'cenik\/(\d+)\/prilohy;new$';
    public $myDirection = 'output';
    public $myFormat = 'html';

    public function process()
    {
        $this->content = new \Ease\TWB\WebPage(_('New pricelist Attachment'));
        $this->content->addItem(new \Ease\TWB\SubmitButton(''));
    }
}
