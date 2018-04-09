<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Operation;

use Kernel\INTENT\Intent;
use Kernel\Model\Base_Donnee\MetaDatabase;
use Kernel\Model\Query\QuerySQL;

/**
 * Description of FORM
 *
 * @author wassime
 */
class Statistique extends MetaDatabase {

    private $schema;
    private $schema_statistique = [];

    public function __construct($PathConfigJsone) {

        parent::__construct($PathConfigJsone);

        $sh = $this->getALLschema();

        foreach ($sh as $value) {
            $st = ($value->select_statistique_SUM());
            if (!empty($st["select"])) {

                $this->schema_statistique[$st["table"]] = ["champ" => $st["select"],
                    "par" => $st["FOREIGN_KEY"]];
            }
        }
    }

    ////////////////////////////////////////////////////////////////////////////////



    public function statistique_global() {

        foreach ($this->schema_statistique as $table => $st) {

            $champ = $st["champ"];
            echo "<h1> $table </h1>";
            $sql = ((new QuerySQL())
                            ->select($champ)
                            ->from($table)
                            ->where("YEAR(`date`)=2018")
                    );


            $entity = $this->query($sql);
            var_dump(Intent::entitys_TO_array($entity)[0]);
        }
    }

    public function statistique_par() {

        foreach ($this->schema_statistique as $table => $st) {

            $champ = $st["champ"];
            $par = $st["par"];
            echo "<h1> $table </h1>";
            foreach ($par as $by) {
                echo "<h3> $by </h3>";
                $sql = ((new QuerySQL())
                                ->select($champ)
                                ->column("$by.$by")
                                ->from($table)
                                ->join($by)
                                ->where("YEAR(`date`)=2018"
                                )
                        );


                $entity = $this->query($sql . " GROUP BY $by ");
                var_dump(Intent::entitys_TO_array($entity));
            }
        }
    }

    public function total($table, $champ, $alias, $date) {

        var_dump($this->schema_statistique);
        $sql = "SELECT  SUM($champ) as $alias FROM $table WHERE YEAR(`date`)=$date ";

        $entity = $this->query($sql);

        return Intent::entitys_TO_array($entity);
    }

    public function totalpar($table, $champ, $alias, $date, $by) {
        $sql = "SELECT $by, SUM($champ) as $alias FROM $table WHERE YEAR(`date`)=$date "
                . " GROUP BY $by ";

        $entity = $this->query($sql);

        return Intent::entitys_TO_array($entity);
    }

}
