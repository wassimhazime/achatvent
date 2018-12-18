<?php

use Phinx\Migration\AbstractMigration;
use Kernel\Conevert\HTML_Phinx;

class famillesDesArticles extends AbstractMigration
{

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
    public function change()
    {



        $this->table('familles$des$articles', HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::text_master('familles$des$articles'))
                ->addColumn(HTML_Phinx::textarea('note'))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->create();
    }
}
