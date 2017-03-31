<?php

/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 Vitex Software (G)
 */

namespace FlexiProxy;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$flexi = new FlexiProxy(null, ['config' => 'config.json']);


$version = 'development';
if (file_exists('/usr/share/flexicen/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/flexicen/composer.json'));
    $version = $composerInfo->version;
}


$flexi->addStatusMessage('FlexiCen v.' . $version . ' FlexiPeeHP v' . \FlexiPeeHP\FlexiBeeRO::$libVersion . ' (FlexiBee ' . \FlexiPeeHP\EvidenceList::$version . ') EasePHP Framework v' . \Ease\Atom::$frameworkVersion, 'debug');


$flexi->output();
