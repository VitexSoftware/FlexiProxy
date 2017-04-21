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

    public function __construct($evidence)
    {
        parent::__construct('customColumn');
        $this->addItem(new \Ease\Html\InputHiddenTag($evidence, $evidence));
        $this->addInput(new \Ease\Html\InputTextTag('name'), _('Column Name'));
        $this->addItem(new \Ease\TWB\SubmitButton(_('Create'), 'success'));
    }
}
