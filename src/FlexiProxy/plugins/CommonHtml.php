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
    /**
     * WebPage helper
     * @var \Ease\TWB\WebPage 
     */
    public $webPage  = null;

    /**
     * HTML page handler
     * 
     * @param \FlexiProxy $flexiProxy
     */
    public function __construct($flexiProxy)
    {
        parent::__construct($flexiProxy);
        $this->webPage = new \Ease\TWB\WebPage;
    }

    public function addCss($code)
    {
        $this->content = $parts[0]."\n<script type=\"text/javascript\">\n$code\n</script>\n".'</body>'.$parts['1'];
        return $this->addBefore($before, $content);
    }

    public function includeCss($css)
    {
        return $this->addBefore('</head>',
                "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"$css\" media=\"all\" />\n");
    }

    public function addJavaScript($code)
    {
        $parts         = explode('</body>', $this->content);
        $this->content = $parts[0]."\n<script type=\"text/javascript\">\n$code\n</script>\n".'</body>'.$parts['1'];
    }

    public function includeJavaScript($url)
    {
        $this->addBefore('</body>',
            "\n<script type=\"text/javascript\" src=\"$url\" ></script>\n");
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

    public function addToPageTop($content)
    {
        return $this->addAfter('<!--FLEXIBEE:PAGE:START-->', $content);
    }
}
