<?php
/**
 * FlexiProxy Send mail with Invoice .
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 *
 * @package   flexiproxy-custom-columns
 */

namespace FlexiProxy\plugins\output\html;

/**
 * Add Send mail button to invoice page
 *
 * @author vitex
 */
class InvoiceSendButton extends \FlexiProxy\plugins\output\CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{
    public $myPathRegex = '\/c\/([a-z_]+)\/faktura-vydana\/([0-9]+)$';
    public $myDirection = 'output';

    public function process()
    {
        $this->addToToolbar(new \Ease\TWB\LinkButton($this->flexiProxy->baseUrl.'/invoicesend.php?company='.$this->flexiProxy->company.'&evidence='.$this->flexiProxy->getEvidence().'&id='.$this->flexiProxy->getMyKey(),
            [new \Ease\Html\ImgTag($this->flexiProxy->baseUrl.'/images/sendmail.svg',
                _('Send by mail'), ['style' => 'height: 15px;']), ' ', _('Send')],
            'success btn-sm'));
    }
}
