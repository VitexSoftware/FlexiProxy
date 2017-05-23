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
class CustomColumnForm extends \Ease\TWB\Form
{

    public function __construct($company, $evidence)
    {
        parent::__construct('customColumn');

        $this->addItem(new \Ease\Html\InputHiddenTag('evidence', $evidence));
        $this->addItem(new \Ease\Html\InputHiddenTag('company', $company));
        $this->addInput(new \Ease\Html\InputTextTag('name'),
            _('New Column Name'));

        $buttonsRow = new \Ease\TWB\Row();
        $buttonsRow->addColumn(4,
            new \Ease\TWB\SubmitButton(_('Create'), 'success'));
        $buttonsRow->addColumn(4);
        $buttonsRow->addColumn(4,
            new \Ease\TWB\LinkButton($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/c/'.$company.'/'.$evidence,
            \FlexiPeeHP\EvidenceList::$name[$evidence], 'info'));
        $this->addItem($buttonsRow);
    }
}
