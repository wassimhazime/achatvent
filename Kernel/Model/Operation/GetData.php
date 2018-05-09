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
        if (Intent::is_show_MASTER($mode)) {
            $champs = $schema->select_master();
        } elseif (Intent::is_show_ALL($mode)) {
            $champs = $schema->select_all();
        } elseif (Intent::is_show_DEFAULT($mode)) {
            $champs = $schema->select_default();
        }
        $sql = (new QuerySQL())
                ->select($champs)
                ->from($schema->getNameTable())
                ->join($schema->getFOREIGN_KEY())
                ->where($condition)
                ->query();

        $Entitys = $this->query($sql);

        $this->setDataJoins($Entitys, $mode);

        return new Intent($schema, $Entitys, $mode);
    }

    public function find_by_id($id): array {
        $schema = $this->schema;

        $condition = ["{$schema->getNameTable()}.id" => $id];

        $Entitys = $this->query((new QuerySQL())
                        ->select($schema->getCOLUMNS_master())
                        ->column($schema->getFOREIGN_KEY())
                        ->from($schema->getNameTable())
                      
                        ->where($condition));


        return \Kernel\Tools\Tools::entitys_TO_array($Entitys[0]);
    }

    private function setDataJoins(array $Entitys, array $mode) {
        $schema = $this->schema;

        foreach ($Entitys as $Entity) {
            if (!empty($schema->get_table_CHILDREN())and Intent::is_get_CHILDREN($mode)) {
                foreach ($schema->get_table_CHILDREN() as $tablechild) {
                    $sql = (new QuerySQL())
                            ->select($schema->select_CHILDREN($tablechild, $mode[1]))
                            ->from($schema->getNameTable())
                            ->join($tablechild, " INNER ", true)
                            ->where($schema->getNameTable() . ".id = " . $Entity->id)
                            ->query();

                    $Entity->setDataJOIN($tablechild, $this->query($sql));
                }
            } else {
                $Entity->setDataJOIN("empty", []);
            }
        }
    }

}
