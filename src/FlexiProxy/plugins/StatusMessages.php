<?php
/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2016-2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins;

/**
 * Description of PricelistImages
 *
 * @author vitex
 */
class StatusMessages extends CommonHtml implements CommonPluginInterface
{
    public $myDirection = 'output';

    public function process()
    {
        $statusMessages = $this->webPage->getStatusMessagesAsHtml();
        if ($statusMessages) {
            $this->includeCss('/css/flexiproxy.css');
            $this->includeJavaScript('/js/slideupmessages.js');
            $messagesBar = new \Ease\Html\Div($statusMessages,
                ['id' => 'StatusMessages', 'class' => 'well', 'title' => _('Click to hide messages'),
                'data-state' => 'down']).
                new \Ease\Html\Div(null, ['id' => 'smdrag'])
            ;
            $this->webPage->cleanMessages();
            $this->addAfter('<div class="flexibee-application-content column " role="main">',
                $messagesBar);
        }


//        $this->includeJavaScript($processed, 'js/PricelistImages.js');
//        $this->addJavaScript($processed, 'alert("listing images");');
    }
}
