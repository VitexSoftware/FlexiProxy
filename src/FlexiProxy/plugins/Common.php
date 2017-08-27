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

    /**
     * Regular Replace
     *
     * @param string $what find
     * @param string $to   replace
     */
    public function pregReplaceContent($what, $to)
    {
        $replaced = preg_replace($what, $to, $this->content);
        if (is_null($replaced)) {
            $this->flexiProxy->addStatusMessage(get_class($this).': '.sprintf(_('Replace %s to %s on %s failed'),
                    $what, $to, $this->flexiProxy->uriRequested), 'warning');
        } else {
            $this->content = $replaced;
        }
    }

    /**
     * Add Given String before found fragment
     *
     * @param string $before
     * @param string $add
     */
    public function addBefore($before, $add)
    {
        if (self::isRegex($before)) {
            $regFound = self::pregFind($before, $this->content);
            if (!empty($regFound)) {
                $before = $regFound;
            }
        }
        if (strstr($this->content, $before)) {
            $parts         = explode($before, $this->content);
            $this->content = $parts[0]."\n$add\n$before\n".$parts['1'];
        } else {
            $this->flexiProxy->addStatusMessage(sprintf(_('AddBefore: pattern "%s" not found on %s'),
                    htmlentities($before), $this->flexiProxy->url), 'warning');
        }
    }

    /**
     * Add Given String after found fragment
     *
     * @param string $after
     * @param string $add
     */
    public function addAfter($after, $add)
    {
        if (self::isRegex($after)) {
            $regFound = self::pregFind($after, $this->content);
            if (!empty($regFound)) {
                $after = $regFound;
            }
        }

        if (strstr($this->content, $after)) {
            $parts         = explode($after, $this->content);
            $this->content = $parts[0]."\n$after\n$add".$parts['1'];
        } else {
            $this->flexiProxy->addStatusMessage(sprintf(_('AddAfter: pattern "%s" not found on %s'),
                    htmlentities($after), $this->flexiProxy->url), 'warning');
        }
    }

    /**
     * Process page content by plugin
     */
    public function process()
    {
        $this->flexiProxy->addStatusMessage(sprintf(_('Plugin with undefined process()'),
                addslashes(get_class($this))), 'warning');
    }

    /**
     * Check if string is Regular Expression
     *
     * @param string $str0
     *
     * @return boolean
     */
    public static function isRegex($str0)
    {
        $regex = "/^\/[\s\S]+\/$/";
        return preg_match($regex, $str0);
    }

    /**
     * Find Substring by regexp
     *
     * @param string $regexp
     * @param string $subject
     *
     * @return string | null
     */
    public static function pregFind(string $regexp, string $subject)
    {
        $matches = null;
        if (strlen($subject) && preg_match($regexp, $subject, $matches)) {
            $matches = current($matches);
        }
        return $matches;
    }
}
