<?php

/**
 * FlexiProxy Custom Columns for Json.
 *
 * @author    Vítězslav Dvořák <info@vitexsoftware.cz>
 * @copyright 2017 VitexSoftware (G)
 */

namespace FlexiProxy\plugins\output\json;

/**
 * Add Custom Columns to Json Results
 *
 * @author vitex
 */
class CustomColumnsJSON extends CommonJson implements \FlexiProxy\plugins\output\CommonPluginInterface
{

    public $myPathRegex = '\/c\/([a-z_]+)\/([a-z\-]+)\/(\d+)\.json$';
    public $myDirection = 'output';

    public function process()
    {
        $customColumer = new \FlexiProxy\CustomColumns();
        $customColumer->setUpCompany($this->flexiProxy->company);
        $customColumer->setUpTable($this->flexiProxy->evidence);
        $columns       = $customColumer->getColumns();
        if (count($columns) > 1) {
            $data = $customColumer->getRecordData($this->flexiProxy->getMyKey());
            if (count($data)) {
                $this->data = json_decode($this->content, true);
                foreach ($columns as $column) {
                    $name = $column->getName();
                    if ($name == 'id') {
                        continue;
                    }
                    $value = $data[$name];
                    $this->data[$this->flexiProxy->nameSpace][$this->flexiProxy->getEvidence()][0][$name]
                        = $value;
                }
                $this->content = json_encode($this->data);
            }
        }
    }
}
