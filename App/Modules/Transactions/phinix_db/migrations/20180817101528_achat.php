<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Migration\AbstractMigration;

class Achat extends AbstractMigration
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
        /*
          CREATE TABLE `achat` (
          `id` int(10) NOT NULL,
          `net_a_payer` double NOT NULL,
          `mode$paiement` int(11) NOT NULL,
          `N_mode` varchar(200) NOT NULL,
          `date_paiement` date NOT NULL,
          `fichier` varchar(250) DEFAULT NULL,
          `remarque` text DEFAULT NULL,
          `date_ajoute` datetime NOT NULL,
          `date_modifier` datetime NOT NULL,
          `raison$sociale` int(11) NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
         */


        $this->table("achat", HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::number('net_a_payer'))
                ->addColumn(HTML_Phinx::select('mode$paiement'))
                ->addColumn(HTML_Phinx::text_master('N_mode'))
                ->addColumn(HTML_Phinx::date('date_paiement'))
                ->addColumn(HTML_Phinx::file('fichier'))
                ->addColumn(HTML_Phinx::textarea('remarque'))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addColumn(HTML_Phinx::select('raison$sociale'))
                ->addForeignKey('mode$paiement', 'mode$paiement', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->addForeignKey('raison$sociale', 'raison$sociale', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->create();
    }
}
