<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace FlexiProxy;

/**
 * Description of PhinxCustomColumns
 *
 * @author vitex
 */
class PhinxCustomColumns extends \Phinx\Migration\AbstractMigration
{
    /**
     * Current table
     * 
     * @var \Phinx\Db\Table
     */
    public $tabler = null;

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
}
