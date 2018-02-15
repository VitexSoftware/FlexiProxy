<?php
/**
 * FlexiProxy - Page TOP.
 *
 * @author     Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright  2017 Vitex Software
 */

namespace FlexiProxy\ui;

/**
 * Page TOP.
 */
class PageTop extends \Ease\Html\Div
{
    /**
     * Titulek stránky.
     *
     * @var type
     */
    public $pageTitle = '';

    /**
     * Nastavuje titulek.
     *
     * @param string $pageTitle
     */
    public function __construct($pageTitle = null)
    {
        parent::__construct();
        if (!is_null($pageTitle)) {
            \Ease\Shared::webPage()->setPageTitle($pageTitle);
        }
    }

    /**
     * Vloží vršek stránky a hlavní menu.
     */
    public function finalize()
    {
        $this->addItem(new MainMenu());
 //        $this->addItem(new History());
    }
}
