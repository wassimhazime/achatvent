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
class QuerySQL implements I_QuerySQL_LDD, I_QuerySQL_LMD, I_QuerySQL_LCT
{

    private $column = ["*"];
    private $table = [];
    private $conditions = ["1"];
    private $join = [];
    private $action = "";
    private $value;

    // outils
    private function isAssoc(array $arr): bool
    {
        if (array() === $arr) {
            return false;
        }
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    private function setColumn(array $columns)
    {
        if ($columns != null or ! empty($columns)) {
            if ($this->column[0] == "*") {
                $this->column = [];
            }

            foreach ($columns as $args) {
                if (is_array($args)) {
                    if ($this->isAssoc($args)) {
                        foreach ($args as $column => $alias) {
                            $this->column[] = "$column AS `$alias`";
                        }
                    } else {
                        foreach ($args as $column) {
                            $this->column[] = " $column ";
                        }
                    }
                } else {
                    $this->column[] = $args;
                }
            }
        }
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function column()
    {
        /// column query
        //(new QuerySQL())->select()->
        // ->column("nom,age,adress") or
        // ->column("nom")->column("age")->column("adress as ADRESS") or
        // ->column("nom","age","adress") or
        // ->column(["nom","age","adress"])or
        // ->column(["nom","age"],["adress"],"prenom")
        //**** alias
        //->column("nom",["age"=>"age Client"],["adress"])
        //->column("nom",["age as `age Client`"],["adress"])
        $this->setColumn(func_get_args());
        return $this;
    }

    public function select()
    {
        /// select query
        //(new QuerySQL())->
        // ->select("nom,age,adress as ADRESS ") or
        // ->select("nom) ->select("age") ->select("adress as ADRESS") or
        // ->select("nom","age","adress") or
        // ->select(["nom","age","adress"])or
        // ->select(["nom","age"],["adress"],"prenom")
        //**** alias
        //->select("nom",["age"=>"age Client"],["adress"])
        //->select("nom",["age as `age Client`"],["adress"])
        $this->action = "select";
        $this->setColumn(func_get_args());
        return $this;
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function from(string $table, string $alias = '')
    {
        /// form query
        //from("client_table")->from("adress_table")
        //**** alias
        //from("client_table","client")

        if ($alias == '') {
            $this->table[] = $table;
        } else {
            $this->table[] = "$table AS $alias";
        }
        return $this;
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function where()
    {
        /// query where
//
//select()
//                        ->from("test")
//                        ->where(["id_mode_paiement"=>"38"])
//                        ->where("id=5")
//                        ->where("nom=achraf","age=26")
//                        ->where(["ville=bm","d=12/6/9"],"jour=77")
//                        ->where(["client"=>"c66"])
//                        
// SELECT *  FROM  test 
// WHERE ( id_mode_paiement = 38 ) 
// AND ( id=5 ) 
// AND ( nom=achraf ) AND ( age=26 ) 
// AND ( ville=bm ) AND ( d=12/6/9 ) AND ( jour=77 ) 
// AND ( client = c66 )
//                        
//

        if (func_get_args() != null or ! empty(func_get_args())) {
            foreach (func_get_args() as $args) {
                if ($args != null or ! empty($args)) {
                    if ($this->conditions == ["1"]) {
                        $this->conditions = [];
                    }

                    if (is_array($args)) {
                        if ($this->isAssoc($args)) {
                            foreach ($args as $column => $condition) {
                                $this->conditions[] = "( $column = $condition )";
                            }
                        } else {
                            foreach ($args as $arg) {
                                $this->conditions[] = "( $arg )";
                            }
                        }
                    } else {
                        $this->conditions[] = "( $args )";
                    }
                }
            }
        }

        return $this;
    }

    public function whereBETWEEN(string $column, $valeur1, $valeur2)
    {
        //query BETWEEN
        //L’intervalle peut être constitué de chaînes de caractères, de nombres ou de dates
        //new QuerySQL())->select()
        //                  ->from('test')
        //                  ->whereBETWEEN("id", 6, 10)
        //SELECT *  FROM  test WHERE ( id BETWEEN '6' AND '10' )
        //
        
        $this->where("$column BETWEEN '$valeur1' AND '$valeur2'");
        return $this;
    }

    public function whereIn(string $column, array $range)
    {
        //query IN
        //
        //(new QuerySQL())->select()
        //  ->from("test")
        // ->whereIn("id", [37,38,48])
        //SELECT *  FROM  test WHERE ( id IN  ( 37 , 38 , 48 )  )
        $range = ' ( ' . implode(' , ', $range) . ' )';

        $this->where("$column IN $range ");
        return $this;
    }

    public function whereLike(string $column, $LIKE)
    {
        //query Like
        //Ce mot-clé permet d’effectuer une recherche sur un modèle
        //particulier. Il est par exemple possible de rechercher les
        //enregistrements dont la valeur d’une colonne commence par
        // telle ou telle lettre. Les modèles de recherches sont multiple.
        //
        //(new QuerySQL())->select()
        //               ->from('test')
        //               ->whereLike("id",["3%","4%"] )
        //              ->whereLike("nom",["a%","A%"] )
        //              ->whereLike("age","2_" )
        //SELECT *  FROM  test WHERE (
        // ( `id`  LIKE '3%'  )         OR ( `id`  LIKE '4%'  )  )
        // AND ( ( `nom`  LIKE 'a%'  )  OR ( `nom`  LIKE 'A%'  )  )
        //  AND ( age Like '2_'  )

        if (is_array($LIKE)) {
            $liks = [];
            foreach ($LIKE as $link) {
                $liks[] = "( `$column`  LIKE '$link'  ) ";
            }



            $this->where(implode(' OR ', $liks));
        } else {
            $this->where("$column Like '$LIKE' ");
        }
        return $this;
    }

    public function whereNot(string $column, int $value)
    {
        // qury not
        //
        //new QuerySQL())->
        // select()->from('test')
        //->whereNot("age","20" )
        //SELECT *  FROM  test WHERE ( age != 20  )
        //
        $this->where("$column != $value ");
        return $this;
    }

    public function whereNotIn(string $column, array $range)
    {
        //query IN
        //
        //(new QuerySQL())->select()
        //  ->from("test")
        // ->whereNotIn("id", [37,38,48])
        //SELECT *  FROM  test WHERE ( id NOT IN  ( 37 , 38 , 48 )  )
        $range = ' ( ' . implode(' , ', $range) . ' )';

        $this->where("$column NOT IN $range ");
        return $this;
    }

    public function whereNotBETWEEN(string $column, $valeur1, $valeur2)
    {
        // query notbetwen inverst betwin

        $this->where("$column NOT BETWEEN '$valeur1' AND '$valeur2'");
        return $this;
    }

    public function whereNotLike(string $column, $LIKE)
    {
        //query Like
        //Ce mot-clé permet d’effectuer une recherche sur un modèle
        //particulier. Il est par exemple possible de rechercher les
        //enregistrements dont la valeur d’une colonne commence par
        // telle ou telle lettre. Les modèles de recherches sont multiple.
        //
        //(new QuerySQL())->select()
        //               ->from('test')
        //               ->whereNotLike("id",["3%","4%"] )
        //              ->whereNotLike("nom",["a%","A%"] )
        //              ->whereNotLike("age","2_" )
        //SELECT *  FROM  test WHERE (
        // ( `id`  NOT LIKE '3%'  )         OR ( `id`  NOT LIKE '4%'  )  )
        // AND ( ( `nom`  NOT LIKE 'a%'  )  OR ( `nom`  NOT LIKE 'A%'  )  )
        //  AND ( age NOT Like '2_'  )

        if (is_array($LIKE)) {
            $liks = [];
            foreach ($LIKE as $link) {
                $liks[] = "( `$column` NOT LIKE '$link'  ) ";
            }



            $this->where(implode(' OR ', $liks));
        } else {
            $this->where("$column NOT Like '$LIKE' ");
        }
        return $this;
    }

    public function whereNULL(string $column)
    {
        // is null
        $this->where("$column IS NULL");
        return $this;
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////
    private function joinstring($tablejoin, string $type = "INNER", bool $relation = false, string $conditions = '')
    {



//
//( new QuerySQL())->select()
        // ->from('produit')
        // ->join("categorie")
//SELECT *  FROM  produit INNER JOIN categorie ON id_categorie  = categorie_produit
//or
//select()
        // ->from('produit')
        // ->join("categorie","INNER",FALSE,"id_categorie=pro_categorie")
//    SELECT *  FROM  produit INNER JOIN categorie ON  id_categorie=pro_categorie     
//or 
//                      select() ->from('produit')
        //->join("categorie","INNER",true)
//
//SELECT *  FROM  produit 
// INNER JOIN d_produit_categorie ON id_produit=id_produit_detail     
// INNER JOIN categorie           ON id_categorie=id_categorie_detail
//        
        $TABLEpere = $this->table[0];


        if ($relation) {
            $TABLEenfant = $tablejoin;
            $RD = 'r_' . $TABLEpere . '_' . $TABLEenfant;


            //LEFT JOIN d_facture_bl     ON id_facture              =id_facture_detail
            $this->join[] = "  $type JOIN $RD      ON $TABLEpere.id =$RD.id_" . $TABLEpere
                    // LEFT      JOIN  bl             on id_bl                        =id_bl_detail
                    . " $type JOIN $TABLEenfant   ON $TABLEenfant.id =$RD.id_" . $TABLEenfant;
        } else {
            //INNER JOIN raison_sociale ON id_raison_sociale = raison_sociale_facture
            if ($conditions == '') {
                $this->join[] = " $type JOIN $tablejoin ON  $tablejoin.id  = $TABLEpere.$tablejoin";
            } else {
                $join = " $type JOIN $tablejoin ON  " . $conditions;

                $this->join[] = $join;
            }
        }
    }

    public function join($tablejoin, string $type = "INNER", bool $relation = false, string $conditions = '')
    {



        if (is_array($tablejoin)) {
            if ($this->isAssoc($tablejoin)) {
                foreach ($tablejoin as $tableJ => $colums) {
                    $this->joinstring($tableJ, $type, $relation, $conditions);
                }
            } else {
                foreach ($tablejoin as $tableJ) {
                    $this->joinstring($tableJ, $type, $relation, $conditions);
                }
            }
        } else {
            $this->joinstring($tablejoin, $type, $relation, $conditions);
        }

        return $this;
    }

    public function joinAlias(string $tablejoin, string $alias, string $conditions, $type = "INNER")
    {

        //select()
        // ->from('produit')
        // ->joinAlias("Categorie","c","c.id_categorie=pro_categorie")
        //
        //SELECT *  FROM  produit INNER JOIN Categorie AS c ON  c.id_categorie=pro_categorie
        //
        $join = " $type JOIN $tablejoin AS $alias ON  "
                . $conditions;

        $this->join[] = $join;

        return $this;
    }

    public function independent(string $master)
    {
        //
        //select()
        //        ->from('produit')
        //        ->independent("categorie")
        //SELECT *  FROM  produit
        //LEFT JOIN d_categorie_produit ON id_produit_detail =id_produit
        //WHERE (  id_produit_detail IS NULL )
        //
        
        $TABLE = $this->table[0];

        $RD = ' r_' . $master . '_' . $TABLE;
        //LEFT JOIN d_facture_bl ON id_bl_detail =id_bl
        $this->join[] = " LEFT JOIN  $RD ON $RD.id_" . $TABLE . " =$TABLE.id";
        // WHERE id_bl_detail IS NULL
        $this->where(" $RD.id_" . $TABLE . " IS NULL");
        return $this;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////


    public function group($column, $direction = null)
    {
    }

    ///delete
    public function delete()
    {
        $condition = func_get_args();
        if (isset($condition[0])) {
            if (is_array($condition[0])) {
                $condition = $condition[0];
            }
        }


        $this->action = "delete";
        $this->where($condition);

        return $this;
    }

    //insert

    public function insertInto(string $table)
    {
        $this->action = "insert";
        $this->table = [];

        $this->table[] = $table;
        return $this;
    }

    public function value(array $data)
    {
        if ($this->isAssoc($data)) {
            $this->value = " (`" . implode("`, `", array_keys($data)) . "`)" .
                    " VALUES ('" . implode("', '", $data) . "') ";
            return $this;
        }
        return "error value insert querysql";
    }

    //update

    public function update(string $table)
    {
        $this->action = "update";
        $this->table = [];
        $this->table[] = $table;
        return $this;
    }

    public function set(array $data)
    {
     
        $l = "";
        foreach ($data as $x => $x_value) {
            if ($l == "") {
                $l = '  `' . $x . '`' . '=' . '\'' . $x_value . '\'  ';
            } else {
                $l .= " , " . '`' . $x . '`' . '=' . '\'' . $x_value . '\'  ';
            }
        }
        $this->value = " SET " . $l;
        return $this;
    }

    //traitement

    public function query()
    {
        $table = implode(', ', $this->table);
        $join = implode('  ', $this->join);
        $where = ' WHERE ' . implode(' AND ', $this->conditions);




        switch ($this->action) {
            case "select":
                $action = ' SELECT ' . implode(', ', $this->column) . "  FROM  ";

                return $action . $table . $join . $where;

                break;
            case "insert":
                $action = ' INSERT INTO ';
                return $action . $table . $this->value;
                break;

            case "delete":
                $action = 'DELETE FROM ';
                return $action . $table . $where;

                break;

            case "update":
                $action = 'UPDATE  ';
                $set = " " . $this->value;
                return $action . $table . $set . $where;

                break;

            default:
                $action = ' SELECT ' . implode(', ', $this->column) . "  FROM  ";
                return $action . $table . $join . $where;
                break;
        }


        return "";
    }

    public function prepareQuery(): array {
        
        //chwiya tamara
        
        
        
        
         $query["prepare"]="";
        $query["params_execute"]="";
        return $query;  
    }         
    
    
    
    public function __toString()
    {
        return $this->query();
    }
}
