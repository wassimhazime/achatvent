<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Migration\AbstractMigration;

class ModePaiement extends AbstractMigration {

    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change() {
        /*
          CREATE TABLE `mode$paiement` (
          `id` int(10) NOT NULL,
          `mode$paiement` varchar(200) NOT NULL,
          `date_ajoute` datetime NOT NULL,
          `date_modifier` datetime NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
         */


        $this->table('mode$paiement', HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::text_master('mode$paiement'))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addIndex(['mode$paiement'], ['unique' => true])
                ->create();
    }

}
