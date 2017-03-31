<?php

/**
 * FlexiProxy.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 Vitex Software (G)
 */

namespace FlexiProxy;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$flexi = new FlexiProxy('config.json');


$version = 'development';
if (file_exists('/usr/share/flexicen/composer.json')) {
    $composerInfo = json_decode(file_get_contents('/usr/share/flexicen/composer.json'));
    $version = $composerInfo->version;
}


$flexi->addStatusMessage('FlexiCen v.' . $version . ' FlexiPeeHP v' . \FlexiPeeHP\FlexiBeeRO::$libVersion . ' (FlexiBee ' . \FlexiPeeHP\EvidenceList::$version . ') EasePHP Framework v' . \Ease\Atom::$frameworkVersion, 'debug');

use Proxy\Proxy;
use Proxy\Adapter\Guzzle\GuzzleAdapter;
use Proxy\Filter\RemoveEncodingFilter;
use Zend\Diactoros\ServerRequestFactory;

// Create a PSR7 request based on the current browser request.
$request = ServerRequestFactory::fromGlobals();

// Create a guzzle client
$guzzle = new \GuzzleHttp\Client(['verify' => false]);

// Create the proxy instance
$proxy = new Proxy(new GuzzleAdapter($guzzle));

// Add a response filter that removes the encoding headers.
$proxy->filter(new RemoveEncodingFilter());

// Forward the request and get the response.
$response = $proxy->forward($request)->to($flexi->apiurl);

// Output response to the browser.
(new \Zend\Diactoros\Response\SapiEmitter())->emit($response);
