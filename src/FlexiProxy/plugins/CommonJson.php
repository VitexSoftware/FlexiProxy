<?php

/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2016-2017 VitexSoftware (G)
 */

namespace FlexiProx\plugins;

/**
 * Description of CommonHtml
 *
 * @author vitex
 */
class CommonJson extends \FlexiProxy\plugins\output\Common
{
    /**
     * Array of json data
     * @var array
     */
    public $data     = null;

    /**
     * We work only with
     * @var string
     */
    public $myFormat = 'json';

    /**
     * Mangage Json content
     * @param \FlexiProxy\FlexiProxy $flexiProxy
     */
    public function __construct($flexiProxy)
    {
        parent::__construct($flexiProxy);
    }
}
