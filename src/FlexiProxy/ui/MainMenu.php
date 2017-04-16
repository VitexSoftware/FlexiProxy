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
        if ($userID) { //Authenticated user
            if (isset($_SESSION['searchQuery'])) {
                $term = $_SESSION['searchQuery'];
            } else {
                $term = null;
            }

            $nav->addMenuItem(new NavBarSearchBox('search', 'search.php', $term));
            $companer = new \FlexiPeeHP\Company();

            $companiesToMenu = [];
            $companer        = new \FlexiPeeHP\Company();
            $companies       = $companer->getFlexiData();

            if (!isset($companies['company'][0])) {
                $cmpInfo                 = $companies['company'];
                unset($companies['company']);
                $companies['company'][0] = $cmpInfo;
            }

            if (isset($companies['company']) && count($companies['company'])) {
                foreach ($companies['company'] as $company) {
                    $companiesToMenu['?company='.$company['dbNazev']] = $company['nazev'];
                }
                asort($companiesToMenu);

                $nav->addDropDownMenu(_('Company'), $companiesToMenu);

                if (!isset($_SESSION['company'])) { //Auto choose first company
                    $_SESSION['company'] = $companies['company'][0]['dbNazev'];
                    define('FLEXIBEE_COMPANY', $_SESSION['company']);
                }

                $evidenciesToMenu = array_merge(['evidences.php' => _('Overview')],
                    [''], $_SESSION['evidence-menu']);

                if (count($evidenciesToMenu)) {
                    $nav->addDropDownMenu(_('Evidence'), $evidenciesToMenu);
                }
            }


            $nav->addDropDownMenu(_('Tools'),
                [
                'query.php' => _('Query'),
                'changesapi.php' => _('Changes API'),
                'changes.php' => _('Changes Recieved'),
                'fakechange.php' => _('WebHook test'),
                'ucetniobdobi.php' => _('Accounting period')
            ]);
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
