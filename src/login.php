<?php
/**
 * FlexiProxy - Sign in page.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  2017 Vitex Software
 */

namespace FlexiProxy;

require_once 'includes/Init.php';

$login    = $oPage->getRequestValue('login');
$password = $oPage->getRequestValue('password');
$server   = $oPage->getRequestValue('server');
$backurl  = $oPage->getRequestValue('backurl');

if ($login) {
    $oUser = \Ease\Shared::user(new User());
    if ($oUser->tryToLogin($_REQUEST)) {
        if ($oPage->getRequestValue('remember-me')) {
            $_SESSION['bookmarks'][] = ['login' => $login, 'password' => $password,
                'server' => $server];
            $oPage->addStatusMessage(_('Server added to bookmarks'));
        }
        if (!is_null($backurl)) {
            $oPage->redirect($backurl);
        } else {
            $oPage->redirect('index.php');
        }
    }
} else {
    $forceID = $oPage->getRequestValue('force_id', 'int');
    if (!is_null($forceID)) {
        \Ease\Shared::user(new User($forceID));
        $oUser->setSettingValue('admin', true);
        $oUser->addStatusMessage(_('Signed in as: ').$oUser->getUserLogin(),
            'success');
        \Ease\Shared::user()->loginSuccess();

        if (!is_null($backurl)) {
            $oPage->redirect($backurl);
        } else {
            $oPage->redirect('index.php');
        }
    } else {
        $oPage->addStatusMessage(_('Please confirm your login credentials'));
    }
}

$oPage->addItem(new ui\PageTop(_('Sign in')));

$loginFace = new \Ease\Html\Div(null, ['id' => 'LoginFace']);

$oPage->container->addItem($loginFace);

$loginRow   = new \Ease\TWB\Row();
$infoColumn = $loginRow->addItem(new \Ease\TWB\Col(4));

$infoBlock = $infoColumn->addItem(new \Ease\TWB\Well(new \Ease\Html\ImgTag('images/password.png')));
$infoBlock->addItem(_('Login History'));

if (isset($_SESSION['bookmarks']) && count($_SESSION['bookmarks'])) {
    $bookmarks = new \Ease\Html\UlTag(null, ['class' => 'list-group']);
    foreach ($_SESSION['bookmarks'] as $bookmark) {
        $bookmarks->addItemSmart(new \Ease\Html\ATag('login.php?login='.$bookmark['login'].'&password='.$bookmark['password'].'&server='.$bookmark['server'],
            str_replace('://', '://'.$bookmark['login'].'@', $bookmark['server'])),
            ['class' => 'list-group-item']);
    }
    $infoBlock->addItem($bookmarks);
}

$loginColumn = $loginRow->addItem(new \Ease\TWB\Col(4));

$submit = new \Ease\TWB\SubmitButton(_('Sign in'), 'success');

$loginPanel = new \Ease\TWB\Panel(new \Ease\Html\ImgTag('images/logo-flexiproxy.png'),
    'success', null, $submit);
$loginPanel->addItem(new \Ease\TWB\FormGroup(_('User name'),
    new \Ease\Html\InputTextTag('login', $login ? $login : ''
    ), '', _('Login name')));
$loginPanel->addItem(new \Ease\TWB\FormGroup(_('Password'),
    new \Ease\Html\InputPasswordTag('password', $password ? $password : ''),
    '',
    _('User\'s password')));

            $companer = new \FlexiPeeHP\Company();

$companiesToMenu = [];
$companer        = new \FlexiPeeHP\Company();
$companies       = $companer->getFlexiData();

if (!isset($companies['company'][0])) {
    $cmpInfo                 = $companies['company'];
    unset($companies['company']);
    $companies['company'][0] = $cmpInfo;
}

if (isset($companies['company']) && count($companies['company'])) {
    foreach ($companies['company'] as $company) {
        $companiesToMenu['/c/'.$company['dbNazev']] = $company['nazev'];
    }
    asort($companiesToMenu);
}


$loginPanel->addItem(new \Ease\TWB\FormGroup(_('Company'),
    new \Ease\Html\Select('company', $companiesToMenu, $company ? $company : ''
    ), '', _('Company')));



$loginPanel->body->setTagCss(['margin' => '20px']);

$loginColumn->addItem($loginPanel);

$featureList = new \Ease\Html\UlTag(null, ['class' => 'list-group']);
$featureList->addItemSmart(_('Show product images'),
    ['class' => 'list-group-item']);

$featuresPanel = new \Ease\TWB\Panel(_('Features'), 'info');

\Ease\Page::addItemCustom($featureList, $featuresPanel);
$loginRow->addColumn(4, $featuresPanel);


$oPage->container->addItem(new \Ease\TWB\Form('Login', null, 'POST', $loginRow));

$oPage->addItem(new ui\PageBottom());

$oPage->draw();
