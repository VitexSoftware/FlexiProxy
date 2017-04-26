<?php

/**
 * FlexiProxy Developer Enhancements.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 *
 * @package   flexiproxy-developer
 */

namespace FlexiProxy\plugins\output\html;

/**
 * Add Buttons for Json & Xml Export
 *
 * @author vitex
 */
class DeveloperEnhancements extends CommonHtml implements \FlexiProxy\plugins\output\CommonPluginInterface
{

    public $myPathRegex = '\/c\/([a-z_]+)\/([a-z\-]+)($|\/(\d+)$|\?)';
    public $myDirection = 'output';

    /**
     * Show Additonal buttons
     */
    public function process()
    {
        $this->addToToolbar(new \Ease\TWB\LinkButton($this->flexiProxy->uriRequested.'.json',
            _('JSON'), 'info btn-sm'));
        $this->addToToolbar(new \Ease\TWB\LinkButton($this->flexiProxy->uriRequested.'.xml',
            _('XML'), 'info btn-sm'));
//        $this->addToToolbar(new \Ease\TWB\LinkButton($this->flexiProxy->uriRequested.'/properties',
//            _('Structure'), 'info btn-sm'));
    }
}
