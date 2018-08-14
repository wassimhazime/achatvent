<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Base_Donnee;

use Kernel\INTENT\Intent_Show;
use Kernel\Model\Query\QuerySQL;

/**
 * Description of Gui
 *
 * @author wassime
 */
class Gui extends Select_Fonctions {
    ////select input simple

    /**
     * 
     * @param type $id
     * @return array
     */
    public function get_id_FOREIGN_KEYs($id): array {
        $FOREIGN_KEYs = $this->getschema()
                ->getFOREIGN_KEY();


        if (empty($FOREIGN_KEYs)) {
            return [];
        }



        $Entitys = $this->prepareQueryAssoc((new QuerySQL())
                        ->select($FOREIGN_KEYs)
                        ->from($this->getTable())
                        ->where(["{$this->getTable()}.id" => $id])
                        ->prepareQuery());

        // is vide
        if (isset($Entitys[0])) {
            return $Entitys[0];
        }

        return[];
    }

    /**
     * pour form select or select input
     * @param array $id_FOREIGN_KEYs
     * @return array
     * 
     */
    public function get_Data_FOREIGN_KEY(array $id_FOREIGN_KEYs = []): array {
        $schema = $this->getschema();
        $nameTable_FOREIGNs = $schema->getFOREIGN_KEY();
        /// charge select input
        $Entitys_FOREIGNs = [];

        foreach ($nameTable_FOREIGNs as $nameTable_FOREIGN) {
            $schem_Table_FOREIGN = $this->getschema($nameTable_FOREIGN);

            $querydataCharge = ( new QuerySQL())
                    ->select($schem_Table_FOREIGN->select_master())
                    ->column($schem_Table_FOREIGN->select_FOREIGN_KEY())
                    ->from($schem_Table_FOREIGN->getNameTable())
                    ->join($schem_Table_FOREIGN->getFOREIGN_KEY());
            /// si is condition
            if (!empty($id_FOREIGN_KEYs) && isset($id_FOREIGN_KEYs[$nameTable_FOREIGN])) {
                $con = [$nameTable_FOREIGN . ".id" => $id_FOREIGN_KEYs[$nameTable_FOREIGN]];
                $querydataCharge->where($con);
            }

            $Entitys_FOREIGNs[$nameTable_FOREIGN] = $this->prepareQuery($querydataCharge->prepareQuery());
        }
        return $Entitys_FOREIGNs;
    }

    public function get_Data_FOREIGN_KEY__ID($id): array {
        //select id de FOREIGN_KEY lier to table
        $id_FOREIGN_KEYs = $this->get_id_FOREIGN_KEYs($id);
        // select data de FOREIGN_KEY
        return $this->get_Data_FOREIGN_KEY($id_FOREIGN_KEYs);
    }

    /////////////////////////////////////////////////////////////////////////////////////
    //************************************************************************************
    ////multiselect input 
    /**
     * 
     * @param array $condition
     * @return array
     */
    public function dataChargeMultiSelectIndependent(array $condition = [], array $mode = Intent_Show::MODE_SELECT_ALL_MASTER): array {
        $schema = $this->getschema();

        $nameTable_CHILDRENs = $schema->get_table_CHILDREN();
        $Entitys_CHILDRENs = [];
        foreach ($nameTable_CHILDRENs as $table_CHILDREN) {

            $FOREIGN_KEY_CHILDRENs = $this->getschema($table_CHILDREN)
                    ->getFOREIGN_KEY();
            $conditions = [];

            foreach ($FOREIGN_KEY_CHILDRENs as $FOREIGN_KEY) {
                if (isset($condition[$FOREIGN_KEY])) {
                    $conditions[] = $FOREIGN_KEY . ".id=" . $condition[$FOREIGN_KEY];
                }
            }




            $querydataCharge = (new QuerySQL())
                    ->select($schema->select_CHILDREN($table_CHILDREN, $mode[1]))
                    ->from($table_CHILDREN)
                    ->join($FOREIGN_KEY_CHILDRENs)
                    ->independent($schema->getNameTable())
                    ->where($conditions);

            $Entitys_CHILDRENs[$table_CHILDREN] = $this->prepareQuery($querydataCharge->prepareQuery());
        }
        return $Entitys_CHILDRENs;
    }

    /**
     * 
     * @param type $id
     * @param array $mode
     * @return type
     */
    public function get_Charge_multiSelect($id, array $mode = Intent_Show::MODE_SELECT_ALL_MASTER) {
        //select id de FOREIGN_KEY lier to table
        $id_FOREIGN_KEYs = $this->get_id_FOREIGN_KEYs($id);
        // select data de MultiSelect || tablechilde
        return $this->dataChargeMultiSelectIndependent($id_FOREIGN_KEYs, $mode);
    }

    /**
     * 
     * @param type $tablechild
     * @param array $condition
     * @return type
     */
//    
//    protected function dataChargeMultiSelectDependent($tablechild, array $condition) {
//        $schema = $this->getschema();
//        $schem_Table_CHILDREN = $this->getschema($tablechild);
//        return $this->prepareQuery((
//                                new QuerySQL())
//                                ->select($schem_Table_CHILDREN->select_NameTable())
//                                ->from($schema->getNameTable())
//                                ->join($tablechild, " INNER ", true)
//                                ->where($condition)
//                                ->prepareQuery());
//    }
}
