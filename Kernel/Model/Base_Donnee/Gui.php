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
     * $id entity save => id_FOREIGN_KEY
     * @param type $id_save
     * @return array
     */
    public function get_id_FOREIGN_KEYs($id_save): array {
        $FOREIGN_KEYs = $this->getschema()
                ->getFOREIGN_KEY();
        if (empty($FOREIGN_KEYs)) {
            return [];
        }

        $id = ["{$this->getTable()}.id" => $id_save];

        $Entitys = $this->prepareQueryAssoc((new QuerySQL())
                        ->select($FOREIGN_KEYs)
                        ->from($this->getTable())
                        ->where($id)
                        ->prepareQuery());


        // is vide
        if (isset($Entitys[0])) {
            return $Entitys[0];
        }

        return[];
    }

    /**
     * pour form select or select input
     * @param array $id_FOREIGN_KEYs exemple ['raison$sociale' =>  '24',...]
     * @param array $mode
     * @return array
     */
    public function get_Data_FOREIGN_KEY(array $id_FOREIGN_KEYs = [], array $mode = Intent_Show::MODE_SELECT_MASTER_NULL): array {
        /// charge select input
        $Entitys_FOREIGNs = [];


        foreach ($this->getschema()->getFOREIGN_KEY() as $nameTable_FOREIGN) {
            // get condition
            //$id_FOREIGN_KEYs   exemple ['raison$sociale' =>  '24',....]
            if (empty($id_FOREIGN_KEYs) || !isset($id_FOREIGN_KEYs[$nameTable_FOREIGN])) {
                $conditions = true;
            } else {
                $conditions = [];
                $id = $id_FOREIGN_KEYs[$nameTable_FOREIGN];
                $conditions[$nameTable_FOREIGN . ".id"] = $id;
            }



            // get data
            $shema_FOREIGN = $this->getschema($nameTable_FOREIGN);
            $Entitys_FOREIGNs[$nameTable_FOREIGN] = $this->select(
                    $mode, $conditions, $shema_FOREIGN
            );
        }

        return $Entitys_FOREIGNs;
    }

    public function get_Data_FOREIGN_KEY__ID($id_save): array {
        //select id de FOREIGN_KEY lier to table
        $id_FOREIGN_KEYs = $this->get_id_FOREIGN_KEYs($id_save);
        // select data de FOREIGN_KEY
        return $this->get_Data_FOREIGN_KEY($id_FOREIGN_KEYs);
    }

////multiselect input 
    /**
     * 
     * @param array $id_FOREIGN_KEYs   exemple ['raison$sociale' =>  '24']
     * @param array $mode
     * @return array
     */
    public function dataChargeMultiSelectIndependent(array $id_FOREIGN_KEYs = [], array $mode = Intent_Show::MODE_SELECT_ALL_MASTER): array {

        $Entitys_CHILDRENs = [];

        foreach ($this->getschema()->get_table_CHILDREN() as $table_CHILDREN) {


            if (empty($id_FOREIGN_KEYs)) {
                $conditions = true;
            } else {
                $conditions = [];
                // independent FOREIGN_KEY
                //array (size=1) 0 => string 'raison$sociale'
                foreach ($this->getschema($table_CHILDREN)->getFOREIGN_KEY() as $FOREIGN_KEY) {
                    if (isset($id_FOREIGN_KEYs[$FOREIGN_KEY])) {
                        $id = $id_FOREIGN_KEYs[$FOREIGN_KEY];
                        $conditions[$FOREIGN_KEY . ".id"] = $id; // exemple ['raison$sociale.id' =>  '24',....] 
                    }
                }
                if (empty($conditions)) {
                    $conditions = true;
                }
            }




            $Entitys_CHILDRENs[$table_CHILDREN] = $this->prepareQuery(
                    (new QuerySQL())
                            ->select($this->getschema()->select_CHILDREN($table_CHILDREN, $mode[1]))
                            ->from($table_CHILDREN)
                            ->join($this->getschema($table_CHILDREN)->getFOREIGN_KEY()) //array [ 0 =>  'raison$sociale']
                            ->independent($this->getTable()) // independent table not lier
                            ->where($conditions) // lier FOREIGN_KEY
                            ->prepareQuery());
        }

        return $Entitys_CHILDRENs;
    }

    /**
     * 
     * @param type $id_save
     * @param array $mode
     * @return type
     */
    public function get_Charge_multiSelect($id_save, array $mode = Intent_Show::MODE_SELECT_ALL_MASTER) {
        //select id de FOREIGN_KEY lier to table
        $id_FOREIGN_KEYs = $this->get_id_FOREIGN_KEYs($id_save);
        // select data de MultiSelect || tablechilde
        return $this->dataChargeMultiSelectIndependent($id_FOREIGN_KEYs, $mode);
    }

    
}
