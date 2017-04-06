<?php

/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2016-2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins;

interface CommonPluginInterface
{

    public function isThisMyFormat($format);

    public function isThisMyPath($path);

    public function process();
}
