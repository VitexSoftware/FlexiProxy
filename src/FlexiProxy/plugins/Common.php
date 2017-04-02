<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FlexiProxy\plugins;

/**
 * Description of Common
 *
 * @author vitex
 */
class Common
{
    public $myPathRegex = '.*';
    public $myFormat    = '.*';
    public $myDirection = '*';
    public $flexiProxy  = null;

    public function __construct($flexiProxy)
    {
        $this->flexiProxy = $flexiProxy;
    }

    public function isThisMyPath($path)
    {
        return preg_match('/'.$this->myPathRegex.'/', $path);
    }

    public function isThisMyFormat($format)
    {
        return preg_match('/^'.$this->myFormat.'$/', $format);
    }

    public function apply()
    {
        switch ($this->myDirection) {
            case 'output':
                $this->process($this->flexiProxy->outputData);
                break;
            case 'input':
                $this->process($this->flexiProxy->inputData);
                break;
        }
    }

    public function process(&$docData)
    {
    }
}
