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
     * Name of default config file
     * @var string
     */
    public $configFile = 'custom-menu.json';

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
        $leftMenu  = \Ease\Shared::instanced()->getConfigValue('left-menu');
        $rightMenu = \Ease\Shared::instanced()->getConfigValue('right-menu');

        if (count($leftMenu)) {
            foreach ($leftMenu as $menuName => $menuItems) {
                $this->addToMainMenu(is_array($menuItems) ? $this->addDropDownMenu($menuName,
                            $menuItems) : new \Ease\Html\LiTag(new \Ease\Html\ATag($menuName,
                        $menuItems),
                        strstr(\Ease\WebPage::getUri(), $menuName) ? ['class' => 'active']
                                : [
                        ] ));
            }
        }
        if (count($rightMenu)) {
            foreach (array_reverse($rightMenu) as $menuName => $menuItems) {
                $this->addToMainMenu(is_array($menuItems) ? $this->addDropDownMenu($menuName,
                            $menuItems) : new \Ease\Html\LiTag(new \Ease\Html\ATag($menuName,
                        $menuItems),
                        strstr(\Ease\WebPage::getUri(), $menuName) ? ['class' => 'active']
                                : [
                            ] ), 'right');
            }
        }
    }
}
