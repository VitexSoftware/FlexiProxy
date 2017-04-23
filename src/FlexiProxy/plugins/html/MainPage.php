<?php

/**
 * FlexiProxy main page plugin.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins\html;

/**
 * Redirect to mainpage
 *
 * @author vitex
 */
class MainPage extends CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{

    public $myPathRegex = '\/$';
    public $myDirection = 'output';

    public function process()
    {
        header('Location: '.$this->flexiProxy->baseUrl.'/index.php');
    }
}
