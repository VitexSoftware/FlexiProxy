<?php
/**
 * FlexiProxy - Hlavní strana.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  2016-2017 Vitex Software
 */

namespace FlexiProxy;

require_once 'includes/Init.php';

$evidence = $oPage->getRequestValue('evidence');

$name = $oPage->getRequestValue('name');
if (strlen($evidence) && strlen($name)) {
    $customColumer = new CustomColumns(1, null, null);
    $customColumer->setUpTable($evidence);
    $customColumer->addColumn($name);
    $oPage->addStatusMessage(sprintf(_('Created column %s in evidence %s'),
            $name, $evidence), 'success');
}


$oPage->onlyForLogged();

$oPage->addItem(new ui\PageTop(_('FlexiProxy')));

$oPage->container->addItem(
    new \Ease\TWB\Panel(sprintf(_('Custom Columns for %s'), $evidence),
    'success', new ui\CustomColumnForm($evidence))
);





$oPage->addItem(new ui\PageBottom());

$oPage->draw();
