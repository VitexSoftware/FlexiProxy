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
class Logout extends \FlexiProxy\plugins\output\CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{

    public $myPathRegex = 'login-logout\/logout$';
    public $myDirection = 'output';
    public $myFormat = 'html';

    public function process()
    {
        header('Location: '.$this->flexiProxy->baseUrl.'/logout.php');
    }
}
