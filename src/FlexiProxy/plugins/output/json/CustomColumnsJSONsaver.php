<?php

/**
 * FlexiProxy Custom Columns saver for Json.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins\output\json;

/**
 * Save custom columns values from analyzed json
 *
 * @author vitex
 */
class CustomColumnsJSONsaver extends CommonJson implements \FlexiProxy\plugins\output\CommonPluginInterface
{

    public $myPathRegex = '.*';
    public $myDirection = 'input';

    public function process()
    {
        $this->flexiProxy->addStatusMessage('******************');
    }
}
