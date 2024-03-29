<?php
/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2016-2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins\input\html;

/**
 * Description of PricelistImages
 *
 * @author vitex
 */
class TakeNewPricelistAttachment extends \FlexiProxy\plugins\output\CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{
    public $myPathRegex = '(\d+)\/prilohy;new$';
    public $myDirection = 'input';
    public $myFormat    = 'html';

    public function process()
    {
        $this->flexiProxy->readFromUpstream = false;
        $informer = new \AbraFlexi\RO($this->flexiProxy->getMyKey(),
            ['evidence' => $this->flexiProxy->getEvidence(), 'company' => $this->flexiProxy->getCompany()]);

        if (isset($_FILES['upload']) && strlen($_FILES['upload']['tmp_name'])) {
            $attachmentFile     = $_FILES['upload']['tmp_name'];
            $attachmentFileName = sys_get_temp_dir().'/'.$_FILES['upload']['name'];

            move_uploaded_file($attachmentFile, $attachmentFileName);

            $result = \AbraFlexi\Priloha::addAttachmentFromFile($informer,
                    $attachmentFileName);
            if ($result == 201) {
               $informer->addStatusMessage(sprintf(_('File %s was attached'),
                        basename($attachmentFileName)), 'success');
            } else {
                $informer->addStatusMessage('Attachment '.$informer->getAbraFlexiURL().' Failed',
                    'error');
            }
            unlink($attachmentFileName);
        }

    }
}
