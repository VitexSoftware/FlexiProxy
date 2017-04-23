<?php

/**
 * FlexiProxy Login Plugin.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins\html;

/**
 * Redirect to login page
 *
 * @author vitex
 */
class Login extends CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{

    public $myPathRegex = 'login-logout\/login-form$';
    public $myDirection = 'output';
    public $myFormat = 'html';

    public function process()
    {
        header('Location: '.$this->flexiProxy->baseUrl.'/logout.php');
    }
}
