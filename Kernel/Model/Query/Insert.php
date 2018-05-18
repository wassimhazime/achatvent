<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Query;

/**
 * Description of Insert
 *
 * @author wassime
 */
class Insert extends Abstract_Query {

    function __construct(string $table) {
        $this->action = "insert";
        $this->table = [];

        $this->table[] = $table;
    }

    public function value(array $data) {

        if ($this->isAssoc($data)) {
            // sql simple
            $this->value = " (`" . implode("`, `", array_keys($data)) . "`)" .
                    " VALUES ('" . implode("', '", $data) . "') ";



            // sql prepare
            $valuep = [];
            $sqlp = [];

            foreach ($data as $key => $value) {

                $sqlp[] = "?";
                $valuep[] = $value;
            }

            $this->valuePrepare["sql"] = " (`" . implode("`, `", array_keys($data)) . "`)" .
                    " VALUES (" . implode(" , ", $sqlp) . ") ";
            $this->valuePrepare["value"] = $valuep;

            return $this;
        }
        return "error value insert querysql";
    }

    //traitement

    public function query(): string {
        $table = implode(', ', $this->table);

        $action = ' INSERT INTO ';
        return $action . $table . $this->value;
    }

    public function prepareQuery(): array {

        $table = implode(', ', $this->table);



        $action = ' INSERT INTO ';
        return["prepare" => $action . $table . $this->valuePrepare["sql"],
            "execute" => $this->valuePrepare["value"]];
    }

}
