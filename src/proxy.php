<?php
/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 Vitex Software (G)
 */

namespace FlexiProxy;

require_once 'includes/Init.php';
$flexi->input();
$flexi->output();


//
//$version = 'development';
//if (file_exists('/usr/share/flexiproxy/composer.json')) {
//    $composerInfo = json_decode(file_get_contents('/usr/share/flexiproxy/composer.json'));
//    $version = $composerInfo->version;
//}
//
//$flexi->addStatusMessage('Flexiproxy v.'.$version.' FlexiPeeHP v'.\FlexiPeeHP\FlexiBeeRO::$libVersion.' (FlexiBee '.\FlexiPeeHP\EvidenceList::$version.') EasePHP Framework v'.\Ease\Atom::$frameworkVersion,
//    'debug');


