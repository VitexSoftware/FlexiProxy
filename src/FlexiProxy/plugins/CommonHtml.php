<?php

/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2016-2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins;

/**
 * Description of CommonHtml
 *
 * @author vitex
 */
class CommonHtml extends Common
{

    public $myFormat = 'html';

    public function addJavaScript($code)
    {
        $parts = explode('</body>', $this->content);
        $this->content = $parts[0] . "\n<script type=\"text/javascript\">\n$code\n</script>\n" . '</body>' . $parts['1'];
    }

    public function includeJavaScript($url)
    {
        $parts = explode('</body>', $this->content);
        $this->content = $parts[0] . "\n<script type=\"text/javascript\" src=\"$url\" ></script>\n" . '</body>' . $parts['1'];
    }

    public function addToBodyEnd($content)
    {
        $parts = explode('</body>', $this->content);
        $this->content = $parts[0] . "\n$content\n</body>" . $parts['1'];
    }

    public function addBefore($before, $content)
    {
        $parts = explode($before, $this->content);
        $this->content = $parts[0] . "\n$content\n$before\n" . $parts['1'];
    }

    public function addAfter($after, $content)
    {
        $parts = explode($after, $this->content);
        $this->content = $parts[0] . "\n$content\n$after" . $parts['1'];
    }

}
