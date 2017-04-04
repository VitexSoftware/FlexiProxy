<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
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

    public function addJavaScript(&$document, $code)
    {
        $parts = explode('</body>', $document);
        $document = $parts[0] . "\n<script type=\"text/javascript\">\n$code\n</script>\n" . '</body>' . $parts['1'];
    }

    public function includeJavaScript(&$document, $url)
    {
        $parts = explode('</body>', $document);
        $document = $parts[0] . "\n<script type=\"text/javascript\" src=\"$url\" ></script>\n" . '</body>' . $parts['1'];
    }

    public function addToBodyEnd(&$document, $content)
    {
        $parts = explode('</body>', $document);
        $document = $parts[0] . "\n$content\n</body>" . $parts['1'];
    }

    public function addAfter(&$document, $after, $content)
    {
        $parts = explode($after, $document);
        $document = $parts[0] . "\n$content\n$after" . $parts['1'];
    }

}
