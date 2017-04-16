<?php
/**
 * FlexiProxy - App inti.
 *
 * @author     Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright  2017 Spoje.Net
 */

namespace FlexiProxy;

require_once '../vendor/autoload.php';

//Initialise Gettext
$langs  = [
    'en_US' => ['en', 'English (International)'],
    'cs_CZ' => ['cs', 'Česky (Čeština)'],
];
$locale = 'en_US';
if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $locale = \locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
}
if (isset($_GET['locale'])) {
    $locale = preg_replace('/[^a-zA-Z_]/', '', substr($_GET['locale'], 0, 10));
}
foreach ($langs as $code => $lang) {
    if ($locale == $lang[0]) {
        $locale = $code;
    }
}
setlocale(LC_ALL, $locale);
bind_textdomain_codeset('flexiproxy', 'UTF-8');
putenv("LC_ALL=$locale");
if (file_exists('../i18n')) {
    bindtextdomain('flexiproxy', '../i18n');
}
textdomain('flexiproxy');

session_start();

/**
 * User class object User or Anonym
 * Objekt uživatele User nebo Anonym
 *
 * @global User|Anonym
 */
$oUser                 = \Ease\Shared::user();
$oUser->settingsColumn = 'settings';

if (!\Ease\Shared::isCli()) {
    /* @var $oPage \Sys\WebPage */
    $oPage = new ui\WebPage();
}

$flexi = new FlexiProxy(null, ['config' => 'config.json']);
