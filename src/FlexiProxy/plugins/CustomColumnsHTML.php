<?php

/**
 * FlexiProxy Custom Columns.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins;

/**
 * Add Custom Columns to evidence item form
 *
 * @author vitex
 */
class CustomColumnsHTML extends CommonHtml implements CommonPluginInterface
{

    public $myPathRegex = '\/$';
    public $myDirection = 'output';

    public function process()
    {
    }
}
