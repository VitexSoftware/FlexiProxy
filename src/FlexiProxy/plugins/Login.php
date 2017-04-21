<?php

/**
 * FlexiProxy Login Plugin.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins;

/**
 * Redirect to login page
 *
 * @author vitex
 */
class Login extends CommonHtml implements CommonPluginInterface
{

    public $myPathRegex = 'login-logout\/login-form$';
    public $myDirection = 'output';
    public $myFormat = 'html';

    public function process()
    {
        header('Location: '.$this->flexiProxy->baseUrl.'/logout.php');
    }
}
