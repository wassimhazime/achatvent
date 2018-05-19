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

        if (isset(func_get_args()[0])) {
            $this->where(func_get_args()[0]);
        }
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
        $where = ' WHERE ' . implode(' AND ', $this->conditionsSimple);
        return 'DELETE FROM ' . $table . $where;
    }

    public function prepareQuery(): Prepare {
        $table = implode(', ', $this->table);
        $execute = $this->conditionsValues;
        $condition = array_merge($this->conditionsPrepares, $this->conditionsPrepares_values);
        $where = " where " . implode(' AND ', $condition);
        $prepare = 'DELETE FROM ' . $table . $where;
        return new Prepare($prepare, $execute);
    }

}
