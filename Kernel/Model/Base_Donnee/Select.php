<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Base_Donnee;
use Kernel\Model\Entitys\EntitysDataTable;

use Kernel\INTENT\Intent_Show;
use Kernel\Model\Query\QuerySQL;
use Kernel\Tools\Tools;
use TypeError;
use function explode;
use function implode;
use function is_string;

/**
 * Description of Select
 *
 * @author wassime
 */
class Select extends MetaDatabase {
    /*
     * ***************************************************************
     *  |show
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |

     */ ///****************************************************************////

    /**
     * 
     * @param string $id
     * @return bool
     */
    public function is_id(string $id): bool {
        $entitysDataTable = $this->find_by_id($id);
        return !$entitysDataTable->is_Null();
    }

    
    public function find_by_id($id, $mode = Intent_Show::MODE_SELECT_ALL_MASTER): EntitysDataTable{

        $Entitys = $this->select($mode, $id);
        

        if (isset($Entitys[0])) {
             return ($Entitys[0]);
        } else {
            $entitysDataTable=new EntitysDataTable();
            $entitysDataTable->setNull();
            return $entitysDataTable ;  
        }
       
    }

    /**
     * get id (exmple:<a class="btn "  role="button" href="/CRM/files/clients_2018-08-01-16-32-12"  data-regex="/clients_2018-08-01-16-32-12/" > <spam class="glyphicon glyphicon-download-alt"></spam> 6</a>)
     * set to table de file upload
     * 
     * @param string $id
     * @return string
     */
    public function get_idfile(string $id): string {
        $schema = $this->getSchema();
        if (empty($schema->getFILES())) {
            return "";
        }
        $Entitys = $this->prepareQuery((new QuerySQL())
                        ->select($schema->getFILES())
                        ->from($schema->getNameTable())
                        ->where(["{$this->getTable()}.id" => $id])
                        ->prepareQuery());
        $datafile = Tools::entitys_TO_array($Entitys[0]);

        return implode($datafile);
    }

    /**
     * pour show or show_in parse mode get les champs|| fildes
     * @param array $mode
     * @return array
     * @throws TypeError
     */
    protected function get_fields(array $mode, $schema = null): array {
        // mode
        if ($schema == null) {
            $schema = $this->getSchema();
        }
        if ($mode[0] == "MASTER") {
            $fields = $schema->select_master();
        } elseif ($mode[0] == "ALL") {
            $fields = $schema->select_all();
        } elseif ($mode[0] == "DEFAULT") {
            $fields = $schema->select_default();
        } else {
            throw new \TypeError(" Error mode intent");
        }

        return $fields;
    }

    /**
     * pour message and show data table html / json
     * @param array $Entitys
     * @param string $mode
     * @return array EntitysDataTable
     */
    protected function get_Data_CHILDREN(array $Entitys, string $mode): array {
        $schema = $this->getSchema();
        foreach ($Entitys as $Entity) {
            if (!empty($schema->get_table_CHILDREN()) && $mode != "EMPTY") {
                foreach ($schema->get_table_CHILDREN() as $tablechild) {
                    $sql = (new QuerySQL())
                            ->select($schema->select_CHILDREN($tablechild, $mode))
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
        return $Entitys;
    }

    /**
     * pour select data to table
     * @param array $mode
     * @param type $id
     * @return array EntitysDataTable
     */
    public function select(array $mode, $id = true): array {
        if ($id !== true) {
            $id = ["{$this->getTable()}.id" => $id];
        }

        $schema = $this->getSchema();
        $fields = $this->get_fields($mode);

        $sql = (new QuerySQL())
                ->select($fields)
                ->column($schema->select_FOREIGN_KEY())
                ->from($schema->getNameTable())
                ->join($schema->getFOREIGN_KEY())
                ->where($id)
                ->prepareQuery();
        $Entitys = $this->prepareQuery($sql);
        return $this->get_Data_CHILDREN($Entitys, $mode[1]);
    }

    /**
     * pour sele data in range 
     * @param array $mode
     * @param string|array $rangeID
     * @return array EntitysDataTable
     */
    public function select_in(array $mode, $rangeID): array {
        $schema = $this->getSchema();
        $fields = $this->get_fields($mode);
        //range
        if (is_string($rangeID)) {
            $rangeID = explode(",", $rangeID);
        }
        $sql = (new QuerySQL())
                ->select($fields)
                ->column($schema->select_FOREIGN_KEY())
                ->from($schema->getNameTable())
                ->join($schema->getFOREIGN_KEY())
                ->whereIn("{$this->getTable()}.id", $rangeID)
                ->prepareQuery();
        $Entitys = $this->prepareQuery($sql);

        return $this->get_Data_CHILDREN($Entitys, $mode[1]);
    }

    /**
     * select data BETWEEN 2 value in id
     * @param array $mode
     * @param int $valeur1
     * @param int $valeur2
     * @return array EntitysDataTable
     */
    public function select_BETWEEN(array $mode, int $valeur1, int $valeur2): array {
        $schema = $this->getSchema();
        $fields = $this->get_fields($mode);

        $sql = (new QuerySQL())
                ->select($fields)
                ->column($schema->select_FOREIGN_KEY())
                ->from($schema->getNameTable())
                ->join($schema->getFOREIGN_KEY())
                ->whereBETWEEN("{$this->getTable()}.id", $valeur1, $valeur2)
                ->prepareQuery();
        $Entitys = $this->prepareQuery($sql);

        return $this->get_Data_CHILDREN($Entitys, $mode[1]);
    }

}
