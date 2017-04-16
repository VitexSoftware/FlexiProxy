<?php
/**
 * FlexiProxy - Hlavní strana.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  2016-2017 Vitex Software
 */

namespace FlexiProxy;

require_once 'includes/Init.php';

$oPage->onlyForLogged();

$oPage->addItem(new ui\PageTop(_('FlexiProxy')));


$oPage->addItem(new ui\PageBottom());

$oPage->draw();
