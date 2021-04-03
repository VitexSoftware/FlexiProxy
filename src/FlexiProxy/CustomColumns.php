<?php

namespace FlexiProxy;

class CustomColumns extends \Ease\Brick
{
    /**
     * DB Structure Modifier
     * @var PhinxCustomColumns
     */
    public $phinx = null;

    /**
     * Columns List
     * @var array
     */
    public $columns = null;

    /**
     * Company - tablename prefix
     * @var string
     */
    public $company = null;

    /**
     * Table - tablename suffix
     * @var string
     */
    public $evidence = null;

    /**
     * Table - tablename suffix
     * @var string
     */
    public $evidenceName = null;

    /**
     * CustomColumns manager
     */
    public function __construct()
    {
        parent::__construct();
        $this->phinx = new PhinxCustomColumns(1, null, null);
    }

    /**
     *
     */
    public function refreshColumnsList()
    {
        $this->columns = $this->phinx->tabler->getColumns();
    }
    /**
     * Set Company code we use
     * 
     * @param string $company
     */
    public function setUpCompany($company)
    {
        $this->company = $company;
    }

    /**
     *
     * @param type $evidence
     */
    public function setEvidence($evidence)
    {
        $this->evidence     = $evidence;
        $this->evidenceName = \AbraFlexi\EvidenceList::$evidences[$evidence]['evidenceName'];

        $evidenceTableName = str_replace('-', '_', $evidence);
        $this->setmyTable($this->company.$evidenceTableName);
        $this->refreshColumnsList();
    }

    /**
     *
     * @param type $myTable
     * @return type
     */
    public function setmyTable($myTable)
    {
        $this->phinx->tabler = $this->phinx->table($myTable);
        $this->phinx->tabler->save();
        return parent::setmyTable($myTable);
    }

    /**
     *
     * @param type $colname
     * @return type
     */
    public function addColumn($colname)
    {
        $result = $this->phinx->tabler->addColumn($colname, 'string')->update();
        $this->refreshColumnsList();
        if (array_key_exists($colname, $this->columns)) {
            $this->addStatusMessage(sprintf(_('Column %s was added to evidence %s'),
                    $colname, $this->evidenceName), 'success');
        } else {
            $this->addStatusMessage(sprintf(_('Column %s was not added from evidence %s'),
                    $colname, $this->evidenceName), 'error');
        }
        return $result;
    }

    /**
     *
     * @param type $colname
     * @return type
     */
    public function removeColumn($colname)
    {
        $result = $this->phinx->tabler->removeColumn($colname)->save();
        $this->refreshColumnsList();
        if (array_key_exists($colname, $this->columns)) {
            $this->addStatusMessage(sprintf(_('Column %s was removed from evidence %s'),
                    $colname, $this->evidenceName), 'success');
        } else {
            $this->addStatusMessage(sprintf(_('Column %s was not removed from evidence %s'),
                    $colname, $this->evidenceName), 'error');
        }
        return $result;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getRecordData($recordID)
    {
        return $this->phinx->fetchRow('SELECT * FROM "'.$this->phinx->tabler->getName().'" WHERE id='.$recordID);
    }
}
