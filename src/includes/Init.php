<?php
/**
 * FlexiProxy - App inti.
 *
 * @author     Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright  2017 Spoje.Net
 */

namespace FlexiProxy;

require_once '../vendor/autoload.php';

\Ease\Shared::initializeGetText('flexiproxy', 'cs_CZ', '../locale');

session_start();

$options = ['confdir' => './'];

if (isset($_SESSION['user'])) {
    $options['user'] = $_SESSION['user'];
}
if (isset($_SESSION['company'])) {
    $options['company'] = $_SESSION['company'];
}
if (isset($_SESSION['password'])) {
    $options['password'] = $_SESSION['password'];
}
$flexi        = new FlexiProxy(null, $options);
/**
 * @var ui\WebPage WebPage Object
 */
$oPage        = new ui\WebPage();
$oPage->flexi = $flexi;


/**
 * User class object User or Anonym
 * Objekt uživatele User nebo Anonym
 *
 * @global User|Anonym
 */
$oUser                 = \Ease\Shared::user();
$oUser->settingsColumn = 'settings';
