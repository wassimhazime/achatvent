<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Query;

/**
 * Description of abstract_Query
 *
 * @author wassime
 */
abstract class Abstract_Query {

    protected $column = ["*"];
    protected $table = [];
    protected $conditions = ["1"];
    protected $conditionsPrepare = [];
    protected $join = [];
    protected $action = "";
    protected $value;
    protected $valuePrepare = ["sql" => "", "value" => ""];

    // outils
    protected function isAssoc(array $arr): bool {
        if (array() === $arr) {
            return false;
        }
        return array_keys($arr) !== range(0, count($arr) - 1);
    }


/////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function where() {
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
                    /// vide condition instial
                    if ($this->conditions == ["1"]) {
                       
                        $this->conditions = [];
                    }

                    if (is_array($args)) {
                        if ($this->isAssoc($args)) {
                            $columns = [];
                            $conditions = [];
                            foreach ($args as $column => $condition) {

                                $this->conditions[] = "( $column = $condition )";

                                $columns[] = "( $column  = ? )";
                                $conditions[] = $condition;
                            }
                            $this->conditionsPrepare = ["sql" => $columns, "conditions" => $conditions];
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


    ////////////////////////////////////////////////////////////////////
    //traitement

    abstract public function query(): string;

    abstract public function prepareQuery(): array;

    public function __toString() {
        return $this->query();
    }

}
