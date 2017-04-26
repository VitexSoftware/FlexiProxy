<?php
/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2016-2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins\output\html;

/**
 * Description of PricelistImages
 *
 * @author vitex
 */
class NewPricelistAttachment extends CommonHtml implements \FlexiProxy\plugins\output\CommonPluginInterface
{
    public $myPathRegex = '(\d+)\/prilohy;new$';
    public $myDirection = 'output';
    public $myFormat    = 'html';

    public function process()
    {
        $informer = new \FlexiPeeHP\FlexiBeeRO($this->flexiProxy->getMyKey(),
            ['evidence' => $this->flexiProxy->getEvidence(), 'company' => $this->flexiProxy->getCompany()]);

        $this->content = new \FlexiProxy\ui\WebPage(_('New pricelist Attachment'));
        $this->content->addItem(new \FlexiProxy\ui\PageTop(_('New Attachment')));

        $row = new \Ease\TWB\Row();

        $allAttachments = \FlexiPeeHP\Priloha::getAttachmentsList($informer);
        if (count($allAttachments)) {
            $lastAttachment = end($allAttachments);
            $columnA = $row->addColumn(6,
            new \Ease\TWB\Panel(_('Latest attachment'), 'info', new \Ease\Html\ImgTag($informer->getFlexiBeeURL().'/prilohy/'.$lastAttachment['id'].'/content',
            $lastAttachment['nazSoub'], ['style' => 'width: 300px;'])));
        }

        $uploadForm = new \Ease\TWB\Form('Attach',
            $this->flexiProxy->uriRequested, 'POST', null,
            ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']);

        $uploadForm->addInput(new \Ease\Html\InputFileTag('upload'),
            _('Attachment File'), 'img.jpg',
            _('image or other record related document'));


        $uploadForm->addItem(new \Ease\TWB\SubmitButton('Upload'));

        $panel = new \Ease\TWB\Panel(sprintf(_('New %s attachment'),
                $informer->getDataValue('nazev')), 'success', $uploadForm);

        $columnB = $row->addColumn(6, $panel);



        $this->content->container->addItem($row);

        $this->content->container->addItem(new \Ease\TWB\LinkButton($this->flexiProxy->fixURLs($this->flexiProxy->apiURL),
            sprintf(_('Back to %s'), $informer->getDataValue('nazev')),
            'success'));

        $this->content->addItem(new \FlexiProxy\ui\PageBottom());
    }
}
