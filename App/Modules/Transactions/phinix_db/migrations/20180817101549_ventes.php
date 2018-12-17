<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Migration\AbstractMigration;

class Ventes extends AbstractMigration
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

--
-- Structure de la table `ventes`
--

CREATE TABLE `ventes` (
  `id` int(10) NOT NULL,
  `clients` int(11) NOT NULL,

  `date` date NOT NULL,
  `montant_factures_TTC` double NOT NULL,
  `montant_paye_TTC` double NOT NULL,
  `Creances_TTC` double DEFAULT 0,
  `remarque` text DEFAULT NULL,
  `date_ajoute` datetime NOT NULL,
  `date_modifier` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

         */
        $this->table('ventes', HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::select('clients'))
                ->addColumn(HTML_Phinx::date('date_negociation'))
                
                ->addColumn(HTML_Phinx::number('montant_factures_TTC'))
                ->addColumn(HTML_Phinx::number('montant_avoirs_TTC'))
                ->addColumn(HTML_Phinx::number('Reglement_TTC'))
                ->addColumn(HTML_Phinx::textarea('remarque'))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addForeignKey('clients', 'clients', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->create();


        HTML_Phinx::relation('ventes', 'vente', $this->getAdapter());


        HTML_Phinx::relation('ventes', 'factures$ventes', $this->getAdapter());
    }
}
