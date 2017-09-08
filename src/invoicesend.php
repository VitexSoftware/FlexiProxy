<?php
/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 Vitex Software (G)
 */

namespace FlexiProxy;

require_once 'includes/Init.php';

$oPage->onlyForLogged($flexi->baseUrl.'/login.php');

$company  = $oPage->getRequestValue('company');
$evidence = $oPage->getRequestValue('evidence');
$id       = $oPage->getRequestValue('id', 'int');

$invoicer = new \FlexiPeeHP\FakturaVydana($id,
    ['company' => $company, 'evidence' => $evidence]);

$firmer = new \FlexiPeeHP\Adresar($invoicer->getDataValue('firma'),
    ['company' => $company]);

$invoice = $invoicer->getData();
$kontakt = $firmer->getData();

if (isset($kontakt['email'])) {
    $mail = new \Ease\Mailer($kontakt['email'],
        sprintf(_('Invoice %s'), $invoice['kod']),
        sprintf(_('Please pay %s,-'), $invoice['sumCelkem']));

    $pdfSaveTo = '/tmp/faktura-vydana-'.$invoice['id'].'.pdf';
    if (file_put_contents($pdfSaveTo, $invoicer->getInFormat('pdf'))) {
        $mail->addFile($pdfSaveTo);
    } else {
        $invoicer->addStatusMessage(sprintf(_('Error saving %s'), $pdfSaveTo),
            'error');
    }

    $isdocxSaveTo = '/tmp/faktura-vydana-'.$invoice['id'].'.isdocx';
    if (file_put_contents($isdocxSaveTo, $invoicer->getInFormat('isdocx'))) {
        $mail->addFile($isdocxSaveTo);
    } else {
        $invoicer->addStatusMessage(sprintf(_('Error saving %s'), $isdocxSaveTo),
            'error');
    }
    if (!$mail->send()) {
        $oPage->addStatusMessage(_('Message was not sent'), 'warning');
    }
    $invoicer->setFormat('html');
    $invoicer->setMyKey($id);
    $oPage->redirect($flexi->fixURLs($invoicer->apiURL));
} else {
    $oPage->addStatusMessage(sprintf(_('Missing email address for '),
            $invoice['firma']), 'warning');
    $firmer->setFormat('html');

    $oPage->redirect($flexi->fixURLs($firmer->apiURL));
}
