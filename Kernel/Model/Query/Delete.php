<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Query;

/**
 * Description of Delete
 *
 * @author wassime
 */
class Delete extends Abstract_Query {

    function __construct() {
        $condition = func_get_args();
        if (isset($condition[0])) {
            if (is_array($condition[0])) {
                $condition = $condition[0];
            }
        }


        $this->action = "delete";
        $this->where($condition);
    }

    public function from(string $table, string $alias = '') {
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

    //traitement

    public function query(): string {
        $table = implode(', ', $this->table);

        $where = ' WHERE ' . implode(' AND ', $this->conditions);

        $action = 'DELETE FROM ';
        return $action . $table . $where;
    }

    public function prepareQuery(): array {

        $table = implode(', ', $this->table);


        if (empty($this->conditionsPrepare)) {
            $where = " where " . implode(' AND ', $this->conditions);
        } else {
            $conditonsprepare = $this->conditionsPrepare["conditions"];
            $where = " where " . implode(' AND ', $this->conditionsPrepare["sql"]);
        }


        $action = 'DELETE FROM ';
        $prepare = $action . $table . $where;
        $execute = ($conditonsprepare);
        return["prepare" => $prepare,
            "execute" => $execute];
    }

}
