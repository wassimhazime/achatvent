<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Operation;

/**
 * Description of Select
 *
 * @author wassime
 */

use Kernel\INTENT\Intent;
use Kernel\Model\Query\QuerySQL;

class GetData extends AbstractOperatipn {

   

    public function select(array $mode, $condition): Intent {

        $schema = $this->schema;

        if (Intent::is_NameTable_MASTER($mode)) {
            $sql = ((new QuerySQL())
                            ->select($schema->select_master())
                            ->from($schema->getNameTable())
                            ->join($schema->getFOREIGN_KEY())
                            ->where($condition));
        } elseif (Intent::is_NameTable_ALL($mode)) {
            $sql = ((new QuerySQL())
                            ->select($schema->select_all())
                            ->from($schema->getNameTable())
                            ->join($schema->getFOREIGN_KEY())
                            ->where($condition));
        }

        $Entitys = $this->query($sql);
        $this->setDataJoins($Entitys, $mode);

        return new Intent($schema, $Entitys, $mode);
    }

    private function setDataJoins(array $Entitys, array $mode) {
        $schema = $this->schema;

        foreach ($Entitys as $Entity) {
            if (!empty($schema->get_table_CHILDREN())and Intent::is_get_CHILDREN($mode)) {
                foreach ($schema->get_table_CHILDREN() as $tablechild) {
                    $Entity->setDataJOIN($tablechild, $this->query((
                                            new QuerySQL())
                                            ->select($schema->select_CHILDREN($tablechild, $mode[1]))
                                            ->from($schema->getNameTable())
                                            ->join($tablechild, " INNER ", true)
                                            ->where($schema->getNameTable() . ".id = " . $Entity->id)));
                }
            } else {
                $Entity->setDataJOIN("empty", []);
            }
        }
    }

}
