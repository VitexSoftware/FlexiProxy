<?php
/**
 * FlexiProxy Custom Buttons in evidence listing
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2018 VitexSoftware (G)
 *
 * @package   flexiproxy-custom-buttons
 */

namespace FlexiProxy\plugins\output\html;

/**
 * Add Custom Buttons to evidence listing
 *
 * @author vitex
 */
class CustomButtonsList extends \FlexiProxy\plugins\output\CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{
    public $myPathRegex = '\/c\/([a-z_]+)\/([a-z\-]+)($|\/(\d+)$|\?)';
    public $myDirection = 'output';

    /**
     * Where to show ?
     * @var strng 
     */
    public $buttonLocation = 'list';

    public function process()
    {
        $buttons = $this->getButtonsForEvidence($this->flexiProxy);
        if ($buttons) {
            foreach ($buttons as $button) {
                $this->addToToolbar(new \Ease\TWB\LinkButton($this->substVars($button['url']),
                        $button['title'], 'warning btn-sm custom-button',
                        ['title' => $button['description'], 'target' => '_blank']));
            }
        }
        $this->includeJavaScript('/js/toggleListingRow.js');
    }

    /**
     * List of buttons for Current Evidence
     * 
     * @param \AbraFlexi\RO $source
     * 
     * @return array
     */
    public function getButtonsForEvidence($source)
    {
        $buttoner = new \AbraFlexi\RO(null,
            array_merge($source->getConnectionOptions(),
                ['evidence' => 'custom-button']));
        return $buttoner->getColumnsFromFlexibee(['kod', 'url', 'title', 'description',
                'location'],
                ['evidence' => $source->getEvidence(), 'location' => $this->buttonLocation]);
    }

    public function substVars($urlRaw)
    {
        if (preg_match('/\$\{[a-z\.]\}/', $urlRaw, $matches)) {
            if (!empty($matches)) {
                foreach ($matches as $match) {
                    
                }
            }
        }

        $urlProcessed = $urlRaw;

        return $urlProcessed;
    }
}
