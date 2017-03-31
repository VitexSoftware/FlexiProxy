<?php

/**
 * FlexiProxy - nastavení testů.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  2017 VitexSoftware
 */
if (file_exists('../vendor/autoload.php')) {
    include_once '../vendor/autoload.php';
} else {
    if (file_exists('vendor/autoload.php')) { //For Test Generator
        include_once 'vendor/autoload.php';
    }
}

define('CONFIG_FILE', 'testing/config.json');
