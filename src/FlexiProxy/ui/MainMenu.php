<?php
/**
 * FlexiProxy - Application Menu.
 *
 * @author     Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright  2017 Vitex Software
 */

namespace FlexiProxy\ui;

class MainMenu extends \Ease\Html\Div
{

    /**
     * Vytvoří hlavní menu.
     */
    public function __construct()
    {
        parent::__construct(null, ['id' => 'MainMenu']);
    }

    /**
     * Data source.
     *
     * @param type   $source
     * @param string $icon   Description
     *
     * @return string
     */
    protected function getMenuList($source, $icon = '')
    {
        $keycolumn  = $source->getmyKeyColumn();
        $namecolumn = $source->nameColumn;
        $lister     = $source->getColumnsFromSQL([$source->getmyKeyColumn(), $namecolumn],
            [$keycolumn => true], $namecolumn, $keycolumn);

        $itemList = [];
        if ($lister) {
            foreach ($lister as $uID => $uInfo) {
                $itemList[$source->keyword.'.php?'.$keycolumn.'='.$uInfo[$keycolumn]]
                    = \Ease\TWB\Part::GlyphIcon($icon).'&nbsp;'.$uInfo[$namecolumn];
            }
        }

        return $itemList;
    }

    /**
     * Vložení menu.
     */
    public function afterAdd()
    {
        $nav = $this->addItem(new BootstrapMenu());

        $userID = \Ease\Shared::user()->getUserID();
        if ($userID || (\Ease\Shared::instanced()->getConfigValue('access_policy')
            == 'public')) { //Authenticated user
            if (isset($_SESSION['searchQuery'])) {
                $term = $_SESSION['searchQuery'];
            } else {
                $term = null;
            }

//            $nav->addMenuItem(new NavBarSearchBox('search', 'search.php', $term));
            $companer = new \FlexiPeeHP\Company();

            $companiesToMenu = [];
            $companer        = new \FlexiPeeHP\Company();
            $companies       = $companer->getFlexiData();

            if (!isset($companies[0])) {
                $cmpInfo      = $companies;
                unset($companies);
                $companies[0] = $cmpInfo;
            }

            if (isset($companies) && count($companies)) {
                foreach ($companies as $company) {
                    $companiesToMenu['/c/'.$company['dbNazev']] = $company['nazev'];
                }
                asort($companiesToMenu);
                $companiesToMenu[]                        = '';
                $companiesToMenu['/admin/zalozeni-firmy'] = \Ease\TWB\Part::GlyphIcon('plus').' '._('Create Company');

                $nav->addDropDownMenu(isset($this->webPage->flexi->company) ? $companiesToMenu['/c/'.$this->webPage->flexi->company]
                            : _('Company'), $companiesToMenu);

                if (!isset($_SESSION['company'])) { //Auto choose first company
                    $_SESSION['company'] = $companies[0]['dbNazev'];
                    if (!defined('FLEXIBEE_COMPANY')) {
                        define('FLEXIBEE_COMPANY', $_SESSION['company']);
                    }
                }
            }

            $leftMenu = \Ease\Shared::instanced()->getConfigValue('left-menu');

            if (count($leftMenu)) {
                foreach ($leftMenu as $menuName => $menuItems) {
                    if (is_array($menuItems)) {
                        $nav->addDropDownMenu($menuName, $menuItems);
                    } else {
                        $nav->addMenuItem(new \Ease\Html\ATag($menuName,
                            $menuItems));
                    }
                }
            }

            $rightMenu = \Ease\Shared::instanced()->getConfigValue('right-menu');
            if (count($rightMenu)) {
                foreach ($rightMenu as $menuName => $menuItems) {
                    if (is_array($menuItems)) {
                        $nav->addDropDownMenu($menuName, $menuItems, 'right');
                    } else {
                        $nav->addMenuItem(new \Ease\Html\ATag($menuName,
                            $menuItems), 'right');
                    }
                }
            }
        }
    }

    /**
     * Přidá do stránky javascript pro skrývání oblasti stavových zpráv.
     */
    public function finalize()
    {
        $this->addCss('body {
                padding-top: 60px;
                padding-bottom: 40px;
            }');

        \Ease\JQuery\Part::jQueryze($this);
        \Ease\Shared::webPage()->addCss('.dropdown-menu { overflow-y: auto } ');
        \Ease\Shared::webPage()->addJavaScript("$('.dropdown-menu').css('max-height',$(window).height()-100);",
            null, true);
        $this->includeJavaScript('/js/slideupmessages.js');
    }
}
