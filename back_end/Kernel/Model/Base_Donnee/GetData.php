<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Base_Donnee;

/**
 * Description of Select
 *
 * @author wassime
 */
use Kernel\INTENT\Intent;
use Kernel\Model\Base_Donnee\DataBase;
use Kernel\Model\Base_Donnee\Schema;
use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Query\QuerySQL;
use TypeError;

class GetData extends DataBase
{

    private $shema;

    public function __construct($PathConfigJsone, $table)
    {

        $this->shema = new Schema($PathConfigJsone);

        parent::__construct($PathConfigJsone, new EntitysDataTable(), $this->shema->getschema($table));
    }

    public function select(array $mode, $condition): Intent
    {

        $schema = $this->entitysSchema;

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

    private function setDataJoins(array $Entitys, array $mode)
    {
        $schema = $this->entitysSchema;

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
