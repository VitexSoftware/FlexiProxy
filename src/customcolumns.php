<?php
/**
 * FlexiProxy - Hlavní strana.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  2016-2017 Vitex Software
 */

namespace FlexiProxy;

require_once 'includes/Init.php';

$evidence      = $oPage->getRequestValue('evidence');
$company       = $oPage->getRequestValue('company');
$customColumer = new CustomColumns(1, null, null);
$customColumer->setUpCompany($company);
$customColumer->setUpTable($evidence);

$name = $oPage->getRequestValue('name');
if (strlen($evidence) && strlen($name)) {
    $customColumer->addColumn($name);
    $oPage->addStatusMessage(sprintf(_('Created column %s in evidence %s'),
            $name, $evidence), 'success');
}

$remove = $oPage->getRequestValue('remove');
if (strlen($evidence) && strlen($remove)) {
    $customColumer->removeColumn($remove);
    $oPage->addStatusMessage(sprintf(_('Removed column %s from evidence %s'),
            $name, $evidence), 'success');
}


$oPage->onlyForLogged();

$oPage->addItem(new ui\PageTop(_('FlexiProxy')));

// $oPage->container->addItem();


$oPage->container->addItem(new \Ease\TWB\Panel(sprintf(_('Custom Columns for %s'),
        $evidence), 'info', new ui\CustomColumnsLister($customColumer),
    new ui\CustomColumnForm($company, $evidence))
);



$oPage->addItem(new ui\PageBottom());
$oPage->draw();
