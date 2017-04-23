<?php
/**
 * FlexiProxy Add Custom Columns to editor
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 *
 * @package   flexiproxy-custom-columns
 */

namespace FlexiProxy\plugins\html;

/**
 * Add Custom Columns input fields to FlexiBee evidence item editor form
 *
 * @author vitex
 */
class AddCustomColumnsToEditor extends CommonHtml implements \FlexiProxy\plugins\CommonPluginInterface
{
    public $myPathRegex = ';(edit|new)$';
    public $myDirection = 'output';

    public function process()
    {
        $customColumer = new \FlexiProxy\CustomColumns(1, null, null);
        $customColumer->setUpCompany($this->flexiProxy->company);
        $customColumer->setUpTable($this->flexiProxy->evidence);
        $columns       = $customColumer->getColumns();
        if (count($columns) > 1) {
            $data = $customColumer->getRecordData($this->flexiProxy->getMyKey());
            $customImputs = new \Ease\TWB\Panel(_('Custom Columns'), 'default');
            foreach ($columns as $column) {
                $name = $column->getName();
                if ($name == 'id') {
                    continue;
                }
                $type  = $column->getType();
                $value = isset($data[$name]) ? $data[$name] : null;

                $this->addAfter(' id: true,', "\n$name: true,\n");
                $this->addAfter(' id: "integer",', "\n$name:\"$type\",\n");
                $customImputs->addItem(new \Ease\TWB\FormGroup($name,
                    new \Ease\Html\InputTextTag($name, $value)));
            }

            $this->addBefore('<div class="flexibee-buttons" >
        <input type="button" name="cancel"', $customImputs);
        }
    }
}
