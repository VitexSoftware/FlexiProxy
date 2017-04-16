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
class CenikXXXprilohy extends CommonHtml implements CommonPluginInterface
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
