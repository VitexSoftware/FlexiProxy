<?php

namespace FlexiProxy\ui;

/**
 * Description of CustomColumnsLister
 *
 * @author vitex
 */
class CustomColumnsLister extends \Ease\TWB\ListGroup
{
    /**
     *
     * @var \FlexiProxy\CustomColumns 
     */
    public $columner = null;

    public function __construct($columner)
    {
        $this->columner = $columner;

        $columnList = [];
        /**
         * @var $ocolumn Phinx\Db\Table\Column PhinxColumn
         */
        $columns    = $columner->getColumns();
        if (count($columns)) {
            foreach ($columns as $ocolumn) {
                if ($ocolumn->getName() != 'id') {
                    $columnList[] = new CustomColumnWidget($ocolumn);
                }
            }
        }
        parent::__construct($columnList);
    }
}
