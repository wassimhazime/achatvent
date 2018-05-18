<?php

//– LDD, LMD & LCT
//LDD : langage de< définition> des données
//Colonnes
//Tables
//Contraintes
//Tables et contraintes
//LMD : langage de <manipulation> des données
//Insertion :insert
//Mise à jour :update
//Suppression :delete
//LCT : langage de< contrôle> des transactions
//Validation :commit
//Annulation :rollback

namespace Kernel\Model\Query;

/**
 * Description of QuerySQL
 *
 * @author Wassim Hazime
 */
class QuerySQL {

    public function select() : Select{
       if (func_get_args()===[]){
             return new Select();  
        }
 
        return new Select(func_get_args());  
    }

    public function insertInto(string $table): Insert {
        return new Insert($table);
    }

    public function update(string $table): Update {
        return new Update($table);
    }

    public function delete($conditions=[]): Delete {
        return new Delete($conditions);
    }

}
