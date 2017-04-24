<?php

/**
 * FlexiProxy Custom Columns.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 *
 * @package   flexiproxy-custom-columns
 */

namespace FlexiProxy\plugins\html;

/**
 * Add Custom Columns to evidence item form
 *
 * @author vitex
 */
class NewCustomColumnButton extends CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{

    public $myPathRegex = '\/c\/([a-z_]+)\/([a-z\-]+)($|\?)';
    public $myDirection = 'output';

    public function process()
    {
        $this->addToToolbar(new \Ease\TWB\LinkButton($this->flexiProxy->baseUrl.'/customcolumns.php?company='.$this->flexiProxy->company.'&evidence='.$this->flexiProxy->getEvidence(),
            _('New Custom Column'), 'success btn-sm'));
    }
}
