<?php

/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins\output\html;

/**
 * Add Images to Pricelits item Attachments List
 *
 * @author vitex
 */
class PricelistImagesShow extends \FlexiProxy\plugins\output\CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{

    public $myPathRegex = 'cenik\/(\d+)\/prilohy';
    public $myDirection = 'output';

    public function process()
    {
        $this->addJavaScript('
$(\'tr > td:nth-child(1) > a\').each(function( index ) {
  $( this ).append(\'<br><img width="100" src="\' + this +  \'/content">\');
});
');
    }
}
