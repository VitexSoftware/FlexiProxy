<?php
/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 Vitex Software (G)
 */

namespace FlexiProxy;

require_once 'includes/Init.php';

$oPage->onlyForLogged($flexi->baseUrl.'/login.php');

if ($oPage->pageClosed === false) {
    $flexi->input();
    $flexi->output();
}

