<?php
/**
 * FlexiProxy main page plugin.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins\output\html;

/**
 * Redirect to mainpage
 *
 * @author vitex
 */
class CustomMenu extends \FlexiProxy\plugins\output\CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{
    public $myPathRegex = '.*';
    public $myDirection = 'output';

    /**
     * Vloží rozbalovací menu.
     *
     * @param string       $label popisek menu
     * @param array|string $items položky menu
     * @param string       $pull  směr zarovnání
     *
     * @return \Ease\Html\ULTag
     */
    public function &addDropDownMenu($label, $items)
    {
        \Ease\Shared::webPage()->addJavaScript('$(\'.dropdown-toggle\').dropdown();',
            null, true);
        $dropDown     = new \Ease\Html\LiTag(null,
            ['class' => 'dropdown', 'id' => $label]);
        $dropDown->addItem(new \Ease\Html\ATag('#',
            $label.'<b class="caret"></b>',
            ['class' => 'dropdown-toggle', 'data-toggle' => 'dropdown']));
        $dropDownMenu = $dropDown->addItem(new \Ease\Html\UlTag(null,
            ['class' => 'dropdown-menu']));
        if (is_array($items)) {
            foreach ($items as $target => $label) {
                if (is_array($label)) {
                    //Submenu
                    $dropDownMenu->addItem($this->addDropDownSubmenu($target,
                            $label));
                } else {
                    //Item
                    if (!$target) {
                        $dropDownMenu->addItem(new \Ease\Html\LiTag(null,
                            ['class' => 'divider']));
                    } else {
                        $dropDownMenu->addItemSmart(new \Ease\Html\ATag($target,
                            $label));
                    }
                }
            }
        } else {
            $dropDownMenu->addItem($items);
        }
        return $dropDown;
    }

    public function process()
    {
        $this->addToMainMenu($this->addDropDownMenu('Custom Menu',
                ['a' => 'b', '', 'c' => 'd']));
        $this->addToMainMenu($this->addDropDownMenu('Custom Right Menu',
                ['e' => 'f', '', 'g' => 'h']), 'right');
    }
}
