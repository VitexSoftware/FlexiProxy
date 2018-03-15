<?php
/**
 * FlexiProxy Status Messages
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins\output\html;

/**
 * Description of PricelistImages
 *
 * @author vitex
 */
class CommonStatusMessages extends \FlexiProxy\plugins\output\CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{
    public $myDirection = 'output';

    public function process()
    {
        $statusMessages = $this->webPage->getStatusMessagesAsHtml();
        $this->includeCss('/css/flexiproxy.css');
        if ($statusMessages) {
            $this->includeJavaScript('/js/slideupmessages.js');
            $messagesBar = new \Ease\Html\Div($statusMessages,
                    ['id' => 'StatusMessages', 'class' => 'well', 'title' => _('Click to hide messages'),
                    'data-state' => 'down']).
                new \Ease\Html\Div(null, ['id' => 'smdrag'])
            ;
            $this->webPage->cleanMessages();

            $content = '<div class="flexibee-application-content column " role="main">';
            if (strstr($this->content, $content)) {
                $this->addAfter($content, $messagesBar);
            } else {
                $this->addToPageTop($messagesBar);
            }
        }
    }
}
