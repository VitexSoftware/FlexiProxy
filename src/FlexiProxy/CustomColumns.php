<?php
namespace FlexiProxy;

use Phinx\Migration\AbstractMigration;

class CustomColumns extends AbstractMigration
{
    /**
     * Current table
     * 
     * @var \Phinx\Db\Table
     */
    public $tabler  = null;

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
    public $tablename = null;

    /**
     * Prepare
     */
    public function init()
    {
        //$pdoFactory = new \Phinx\Db\Adapter\AdapterFactory();
        $dbtype = \Ease\Shared::instanced()->getConfigValue('DB_TYPE');
        switch ($dbtype) {
            case 'pgsql':
                $this->adapter = new \Phinx\Db\Adapter\PostgresAdapter(['connection' => \Ease\Shared::db()->sqlLink]);
                break;
            case 'mysql':
                $this->adapter = new \Phinx\Db\Adapter\MysqlAdapter(['connection' => \Ease\Shared::db()->sqlLink]);
                break;

            default:
                break;
        }
    }

    public function refreshColumnsList()
    {
        $this->columns = $this->tabler->getColumns();
    }


    public function setUpCompany($company)
    {
        $this->company = $company;
    }

    public function setUpTable($tableName)
    {
        $this->tablename = str_replace('-', '_', $tableName);
        $this->tabler    = $this->table($this->company.$this->tablename);
        $this->tabler->save();
        $this->refreshColumnsList();
    }

    public function addColumn($colname)
    {
        $result = $this->tabler->addColumn($colname, 'string')->update();
        $this->refreshColumnsList();
        return $result;
    }

    public function removeColumn($colname)
    {
        $result = $this->tabler->removeColumn($colname)->save();
        $this->refreshColumnsList();
        return $result;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getRecordData($recordID)
    {
        return $this->fetchRow('SELECT * FROM "'.$this->tabler->getName().'" WHERE id='.$recordID);
    }
}
