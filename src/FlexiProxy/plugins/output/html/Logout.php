<?php

/**
 * FlexiProxy Logout Plugin.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins\output\html;

/**
 * Redirect to logout page
 *
 * @author vitex
 */
class Logout extends CommonHtml implements \FlexiProxy\plugins\output\CommonPluginInterface
{

    public $myPathRegex = 'login-logout\/logout$';
    public $myDirection = 'output';
    public $myFormat = 'html';

    public function process()
    {
        header('Location: '.$this->flexiProxy->baseUrl.'/logout.php');
    }
}
