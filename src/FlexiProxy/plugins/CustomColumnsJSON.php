<?php

/**
 * FlexiProxy Custom Columns for Json.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins;

/**
 * Add Custom Columns to Json Results
 *
 * @author vitex
 */
class CustomColumnsJSON extends CommonJson implements CommonPluginInterface
{

    public $myPathRegex = '\/$';
    public $myDirection = 'output';

    public function process()
    {
    }
}
