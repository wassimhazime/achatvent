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
use Kernel\Tools\Tools;

class GetData extends AbstractOperatipn {

    public function select_in(array $mode, $id, $condition): Intent {

        $schema = $this->_getSchema();
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
                ->whereIn($id, $condition)
                ->prepareQuery();

        $Entitys = $this->prepareQuery($sql);

        $this->setDataJoins($Entitys, $mode);

        return new Intent($schema, $Entitys, $mode);
    }

    public function select(array $mode, $condition): Intent {

        $schema = $this->_getSchema();
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
                ->prepareQuery();

        $Entitys = $this->prepareQuery($sql);

        $this->setDataJoins($Entitys, $mode);

        return new Intent($schema, $Entitys, $mode);
    }

    public function is_id($id): bool {
        $schema = $this->_getSchema();

        $condition = ["{$schema->getNameTable()}.id" => $id];

        $Entitys = $this->prepareQuery((new QuerySQL())
                        ->select()
                        ->from($schema->getNameTable())
                        ->where($condition)
                        ->prepareQuery());

        return (!empty($Entitys));
    }

    public function find_by_id($id): array {
        $schema = $this->_getSchema();

        $condition = ["{$schema->getNameTable()}.id" => $id];

        $Entitys = $this->prepareQuery((new QuerySQL())
                        ->select($schema->getCOLUMNS_master())
                        ->column($schema->getFOREIGN_KEY())
                        ->from($schema->getNameTable())
                        ->where($condition)->prepareQuery());


        return Tools::entitys_TO_array($Entitys[0]);
    }

    private function setDataJoins(array $Entitys, array $mode) {
        $schema = $this->_getSchema();

        foreach ($Entitys as $Entity) {
            if (!empty($schema->get_table_CHILDREN())and Intent::is_get_CHILDREN($mode)) {
                foreach ($schema->get_table_CHILDREN() as $tablechild) {
                    $sql = (new QuerySQL())
                            ->select($schema->select_CHILDREN($tablechild, $mode[1]))
                            ->from($schema->getNameTable())
                            ->join($tablechild, " INNER ", true)
                            ->where($schema->getNameTable() . ".id = " . $Entity->id)
                            ->prepareQuery();

                    $Entity->setDataJOIN($tablechild, $this->prepareQuery($sql));
                }
            } else {
                $Entity->setDataJOIN("empty", []);
            }
        }
    }

    public function get_idfile($condition): string {

        $schema = $this->_getSchema();

        if (empty($schema->getFILES())) {
            return "";
        }

        $Entitys = $this->prepareQuery((new QuerySQL())
                        ->select($schema->getFILES())
                        ->from($schema->getNameTable())
                        ->where($condition)->prepareQuery());
        $datafile = Tools::entitys_TO_array($Entitys[0]);



        return implode($datafile);
    }

}
