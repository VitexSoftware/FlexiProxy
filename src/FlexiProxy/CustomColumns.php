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
    public $tabler = null;

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

    public function setUpTable($tableName)
    {
        $this->tabler = $this->table($tableName);
        $this->tabler->save();
    }

    public function addColumn($colname)
    {
        $this->tabler->addColumn($colname, 'string')->update();
    }
}
