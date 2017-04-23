<?php

/**
 * FlexiProxy Custom Columns.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 *
 * @package   flexiproxy-custom-columns
 */

namespace FlexiProxy\plugins\html;

/**
 * Add Custom Columns to evidence item form
 *
 * @author vitex
 */
class CustomColumnsHTML extends CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{

    public $myPathRegex = '\/c\/([a-z_]+)\/([a-z\-]+)\/(\d+)$';
    public $myDirection = 'output';

    public function process()
    {
        $customColumer = new \FlexiProxy\CustomColumns(1, null, null);
        $customColumer->setUpCompany($this->flexiProxy->company);
        $customColumer->setUpTable($this->flexiProxy->evidence);
        $columns       = $customColumer->getColumns();
        if (count($columns) > 1) {
            $data         = $customColumer->getRecordData($this->flexiProxy->getMyKey());
            $customImputs = new \Ease\TWB\Panel(_('Custom Columns'), 'default');
            foreach ($columns as $column) {
                $name = $column->getName();
                if ($name == 'id') {
                    continue;
                }
                $type  = $column->getType();
                $value = isset($data[$name]) ? $data[$name] : null;

                $customImputs->addItem(
                    new \Ease\TWB\Row([new \Ease\TWB\Col(2,
                        new \Ease\Html\StrongTag($name.':')), new \Ease\TWB\Col(10,
                        $value)])
                );
            }

            $this->addToPageBottom($customImputs);
        }
    }
}
