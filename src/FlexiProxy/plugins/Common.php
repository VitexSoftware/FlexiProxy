<?php
/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2016-2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins;

/**
 * Description of Common
 *
 * @author vitex
 */
class Common
{
    /**
     * My URL path regex
     * @var string
     */
    public $myPathRegex = '.*';

    /**
     * My Format type regex
     * @var string
     */
    public $myFormat = '.*';

    /**
     * Request/Response direction
     * @var string input|output|*
     */
    public $myDirection = '*';

    /**
     * Proxy Engine
     * @var \FlexiProxy\FlexiProxy
     */
    public $flexiProxy = null;

    /**
     * Content to be modified
     * @var string
     */
    public $content = null;

    /**
     * Response changer
     *
     * @param type $flexiProxy
     */
    public function __construct($flexiProxy)
    {
        $this->flexiProxy = $flexiProxy;
    }

    /**
     * Is this direction my ?
     *
     * @param string $direction Request/Response URL
     * @return boolean
     */
    public function isThisMyDirection($direction)
    {
        return preg_match('/'.$this->myDirection.'/', $direction);
    }

    /**
     * Is this path my ?
     *
     * @param string $path Request/Response URL
     * @return boolean
     */
    public function isThisMyPath($path)
    {
        return preg_match('/'.$this->myPathRegex.'/', $path);
    }

    /**
     * Is this format my own ?
     *
     * @param string $format
     * @return boolean
     */
    public function isThisMyFormat($format)
    {
        return preg_match('/^'.$this->myFormat.'$/', $format);
    }

    /**
     * Find & Apply plugins related for current content
     */
    public function apply()
    {
        switch ($this->myDirection) {
            case 'output':
                $this->content                = $this->flexiProxy->outputData;
                $this->process();
                $this->flexiProxy->outputData = $this->content;
                break;
            case 'input':
                $this->content                = $this->flexiProxy->inputData;
                $this->process();
                $this->flexiProxy->inputData  = $this->content;
                break;
        }
    }

    public function replaceContent($what, $to)
    {
        $this->content = str_replace($what, $to, $this->content);
    }

    public function preg_replaceContent($what, $to)
    {
        $replaced = preg_replace($what, $to, $this->content);
        if (is_null($replaced)) {
            $this->flexiProxy->addStatusMessage(get_class($this).': '.sprintf(_('Replace %s to %s on %s failed'),
                    $what, $to, $this->flexiProxy->uriRequested), 'warning');
        } else {
            $this->content = $replaced;
        }
    }

    public function process()
    {
        $this->flexiProxy->addStatusMessage(sprintf(_('Plugin with undefined process()'),
                addslashes(get_class($this))), 'warning');
    }
}
