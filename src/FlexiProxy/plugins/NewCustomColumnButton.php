<?php

/**
 * FlexiProxy Custom Columns.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins;

/**
 * Add Custom Columns to evidence item form
 *
 * @author vitex
 */
class NewCustomColumnButton extends CommonHtml implements CommonPluginInterface
{

    public $myPathRegex = '\/c\/([a-z_]+)\/([a-z]+)($|\?)';
    public $myDirection = 'output';

    public function process()
    {
        $this->addToToolbar(new \Ease\TWB\LinkButton($this->flexiProxy->baseUrl.'/customcolumns.php?evidence='.$this->flexiProxy->getEvidence(),
            _('New Custom Column'), 'info'));
    }
}
