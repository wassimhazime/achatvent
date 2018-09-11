<?php

namespace App\Authentification;

use Kernel\Conevert\HTML_Phinx;
use Phinx\Migration\AbstractMigration;

abstract class Autorisation_TablePhinix extends AbstractMigration implements AutorisationInterface{

    protected function create_autorisation(string $nametable) {
        /**
          CREATE TABLE IF NOT EXISTS `autorisation$name` (
          `id` int(10) NOT NULL AUTO_INCREMENT,
          `comptes` int(11) NOT NULL,
         * 
          `controller` varchar(200) NOT NULL,
         * 
          `voir` tinyint(4) DEFAULT 1,
          `ajouter` tinyint(4) DEFAULT 0,
          `modifier` tinyint(4) DEFAULT 0,
          `effacer` tinyint(4) DEFAULT 0,
          `active` tinyint(4) DEFAULT 1,
         * 
          `date_ajoute` datetime NOT NULL,
          `date_modifier` datetime NOT NULL,

          PRIMARY KEY (`id`),
          KEY `autorisation_$id` (`comptes`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


          ALTER TABLE `autorisation$name`
          ADD CONSTRAINT `autorisation_$id` FOREIGN KEY (`comptes`) REFERENCES `comptes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

         */
        
        $this->table(self::Prefixe . $nametable
                        , HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::select('comptes'))
                ->addColumn(HTML_Phinx::text_master('controller'))
                
                ->addColumn(HTML_Phinx::checkBox("voir"))
                ->addColumn(HTML_Phinx::checkBox("ajouter"))
                ->addColumn(HTML_Phinx::checkBox("modifier"))
                ->addColumn(HTML_Phinx::checkBox("effacer"))
    
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->addForeignKey('comptes', 'comptes', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                ->create();
        
      
    }

}
