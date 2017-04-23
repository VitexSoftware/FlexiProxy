<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FlexiProxy\ui;

/**
 * Description of CustomColumnWidget
 *
 * @author vitex
 */
class CustomColumnWidget extends \Ease\TWB\Row

{
    /**
     * CustomColumn 
     * @param \Phinx\Db\Table\Column $ocolumn
     */
    public function __construct($ocolumn)
    {
        parent::__construct();
        $name = $ocolumn->getName();
        $this->addColumn(4, $name);
        $this->addColumn(4, $ocolumn->getType());
        $this->addColumn(4,
            new \Ease\TWB\LinkButton('?company='.
            \Ease\Shared::webPage()->flexi->company.'&evidence='.\Ease\Shared::webPage()->getRequestValue('evidence').'&remove='.$ocolumn->getName(),
            _('Remove Column'), 'danger'));
    }
}
