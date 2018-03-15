<?php
/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2016-2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins\output;

/**
 * Description of CommonHtml
 *
 * @author vitex
 */
class CommonHtml extends \FlexiProxy\plugins\Common
{
    public $myFormat = 'html';

    /**
     * WebPage helper
     * @var \Ease\TWB\WebPage 
     */
    public $webPage = null;

    /**
     * HTML page handler
     * 
     * @param \FlexiProxy $flexiProxy
     */
    public function __construct($flexiProxy)
    {
        parent::__construct($flexiProxy);
        $this->webPage = new \Ease\TWB\WebPage();
    }

    public function addCss($code)
    {
        $this->addBefore('<!--FLEXIBEE:CSS:END-->', $code);
    }

    /**
     * Include CSS to Page
     * 
     * @param string $css
     * 
     * @return null
     */
    public function includeCss($css)
    {
        return $this->addBefore('<!--FLEXIBEE:CSS:END-->',
                "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"".$this->flexiProxy->baseUrl.$css."\" media=\"all\" />\n");
    }

    /**
     * Add Javascript To Page
     * 
     * @param string $code
     * @param array  $onDocumentReady
     * 
     * @return type
     */
    public function addJavaScript($code, $onDocumentReady = true)
    {
        if ($onDocumentReady === true) {
            $docready = '$(document).ready(function() {';
            if (strstr($this->content, $docready)) {
                $result = $this->addAfter($docready, $code);
            } else {
                $result = $this->addBefore('<!--FLEXIBEE:JS:END-->',
                    "\n<script type=\"text/javascript\">\n$docready\n$code\n}\n</script>\n");
            }
        } else {
            $result = $this->addBefore('<!--FLEXIBEE:JS:END-->',
                "\n<script type=\"text/javascript\">\n$code\n</script>\n");
        }
        return $result;
    }

    /**
     * Include Javascript to webpage
     * 
     * @param string $url
     */
    public function includeJavaScript($url)
    {
        $this->addBefore('<!--FLEXIBEE:JS:END-->',
            "\n<script type=\"text/javascript\" src=\"".$this->flexiProxy->baseUrl.$url."\" ></script>\n");
    }

    /**
     *
     * @param string $content
     */
    public function addToBodyEnd($content)
    {
        $parts         = explode('</body>', $this->content);
        $this->content = $parts[0]."\n$content\n</body>".$parts['1'];
    }

    /**
     * Add content to webpage top
     * 
     * @param string $content
     * 
     * @return null
     */
    public function addToPageTop($content)
    {
        return $this->addAfter('<!--FLEXIBEE:PAGE:START-->', $content);
    }

    /**
     *
     * @param type $content
     * @return type
     */
    public function addToPageBottom($content)
    {
        return $this->addAfter('</div> <!-- flexibee-article-view -->', $content);
    }

    /**
     *
     * @param type $content
     * @return type
     */
    public function addToToolbar($content)
    {
        return $this->addBefore('<!--FLEXIBEE:TOOLBAR:END-->', $content);
    }

    /**
     * Add Item into Main menu
     *
     * @param string $content
     * @param type $pull
     *
     * @return type
     */
    public function addToMainMenu($content, $pull = 'left')
    {
        $find    = '/<\/ul>\s*<ul class="nav navbar-nav navbar-right">/';
        $content = '<!-- addToMainMenu -->'.$content.'<!-- addToMainMenu/ -->';
        return $pull == 'left' ? $this->addBefore($find, $content) : $this->addAfter($find,
                $content);
    }
}
