<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Operation;

use Kernel\INTENT\Intent_Form;
use Kernel\Model\Entitys\EntitysSchema;
use Kernel\Model\Query\QuerySQL;
use Kernel\Tools\Tools;

/**
 * Description of FORM
 *
 * @author wassime
 */
class GUI extends AbstractOperatipn {

    ////////////////////////////////////////////////////////////////////////////////
    public function formSelect(): Intent_Form {

        $schema = $this->schema;

        $schemaFOREIGN_KEY = new EntitysSchema();
        $schemaFOREIGN_KEY->setNameTable($schema->getNameTable());
        $schemaFOREIGN_KEY->setCOLUMNS_META($schema->getCOLUMNS_META(["Key" => "MUL"]));
        $schemaFOREIGN_KEY->setFOREIGN_KEY($schema->getFOREIGN_KEY());
        $META_data = $schemaFOREIGN_KEY->getCOLUMNS_META();

        $Charge_data = [];
        $Charge_data ["select"] = $this->datachargeselect();
        $Charge_data["multiselect"] = [];
        $Charge_data["PARENT"] = [];

        $Default_Data = [];

        return new Intent_Form($META_data, $Charge_data, $Default_Data);
    }

    public function form($condition): Intent_Form {

        
        $META_data = $this->schema->getCOLUMNS_META();
        
        $Charge_data = [];
        $Charge_data ["select"] = $this->datachargeselect($condition);
        $Charge_data["multiselect"] = $this->dataChargeMultiSelectIndependent($condition);
        $Charge_data["PARENT"] = [];

        $Default_Data = [];


        return new Intent_Form($META_data, $Charge_data, $Default_Data);
    }

    public function formDefault( array $conditionDefault): Intent_Form {
        $schema = $this->schema;
        
        // data Default
        $Entitys = $this->prepareQuery((new QuerySQL())
                        ->select($schema->select_all())
                        ->from($schema->getNameTable())
                        ->join($schema->getFOREIGN_KEY())
                        ->where($conditionDefault)
                        ->prepareQuery());
       
        $Entity = $Entitys[0];
        
        $conditionformSelect = $this->condition_formSelect_par_condition_Default($conditionDefault);

           // data join (children enfant drari lbrahch ....)
          $nameTable_CHILDRENs = $schema->get_table_CHILDREN();
          $Entitys_CHILDRENs = [];
         if (!empty($nameTable_CHILDRENs)) {
          /// charge enfant data no lier lien
            $Entitys_CHILDRENs = $this->dataChargeMultiSelectIndependent($conditionformSelect);
          /// charge enfant data lien
            foreach ($nameTable_CHILDRENs as $tablechild) {
                $datacharg = $this->dataChargeMultiSelectDependent($tablechild, $conditionDefault);
                $Entity->setDataJOIN($tablechild, $datacharg);
            }
        }


        $Charge_data = [];
        $Charge_data ["select"] = $this->datachargeselect($conditionformSelect);
        $Charge_data["multiselect"] = $Entitys_CHILDRENs;
        $Charge_data["PARENT"] = [];

        $Default_Data = $Entity;


        return new Intent_Form($schema->getCOLUMNS_META(), $Charge_data, $Default_Data);
    }

    /////////////////////////////////////////////////:
    public function formChild(array $datapernt = []): Intent_Form {
        
        $schema = $this->schema;
        $Charge_data = [];
        $Charge_data ["select"] = $this->datachargeselect($datapernt); // avec un sel raison sosial 
        $Charge_data["multiselect"] = [];
        $Charge_data["PARENT"] = $datapernt;

        $Default_Data = [];


        return new Intent_Form($schema->getCOLUMNS_META(), $Charge_data, $Default_Data);
    }

    ///////////////////////////////////////////////////////////////////


    private function datachargeselect(array $condition = []) {

        $schema = $this->schema;

        $nameTable_FOREIGNs = $schema->getFOREIGN_KEY();
        /// charge select input
        $Entitys_FOREIGNs = [];
        foreach ($nameTable_FOREIGNs as $nameTable_FOREIGN) {
            $schem_Table_FOREIGN = $this->getschema($nameTable_FOREIGN);

           

            $querydataCharge =( new QuerySQL())
                    ->select($schem_Table_FOREIGN->select_master())
                    ->from($schem_Table_FOREIGN->getNameTable())
                    ->join($schem_Table_FOREIGN->getFOREIGN_KEY());
            
            if (!empty($condition) && isset($condition[$nameTable_FOREIGN])) {
                $con=[$nameTable_FOREIGN . ".id"=> $condition[$nameTable_FOREIGN]];
                
                $querydataCharge->where($con);
            }


            $Entitys_FOREIGNs[$nameTable_FOREIGN] = $this->prepareQuery($querydataCharge->prepareQuery());
        }
        return $Entitys_FOREIGNs;
    }

    private function dataChargeMultiSelectIndependent(array $condition = []) {

        $schema = $this->schema;

        $nameTable_CHILDRENs = $schema->get_table_CHILDREN();

        $Entitys_CHILDRENs = [];

        foreach ($nameTable_CHILDRENs as $table_CHILDREN) {

            $schem_Table_CHILDREN = $this->getschema($table_CHILDREN);
            $FOREIGN_KEY_CHILDRENs = $schem_Table_CHILDREN->getFOREIGN_KEY();

           


            $querydataCharge=(new QuerySQL())->select($schem_Table_CHILDREN->select_NameTable())
                    ->from($schem_Table_CHILDREN->getNameTable())
                    ->join($FOREIGN_KEY_CHILDRENs)
                    ->independent($schema->getNameTable());

            $query = $this->query_enfant_lier_formSelect($querydataCharge, $condition, $FOREIGN_KEY_CHILDRENs);

            $Entitys_CHILDRENs[$table_CHILDREN] = $this->prepareQuery($query->prepareQuery());
        }

        return $Entitys_CHILDRENs;
    }

    private function dataChargeMultiSelectDependent($tablechild, array $condition) {
        $schema = $this->schema;
        $schem_Table_CHILDREN = $this->getschema($tablechild);
        return $this->prepareQuery((
                                new QuerySQL())
                                ->select($schem_Table_CHILDREN->select_NameTable())
                                ->from($schema->getNameTable())
                                ->join($tablechild, " INNER ", true)
                                ->where($condition)
                                ->prepareQuery());
    }

    private function query_enfant_lier_formSelect( $query, array $condition, array $FOREIGN_KEY_CHILDRENs) {


        if (!empty($condition) and ! empty($FOREIGN_KEY_CHILDRENs)) {
            foreach ($FOREIGN_KEY_CHILDRENs as $FOREIGN_KEY) {
                if (isset($condition[$FOREIGN_KEY])) {
                    $query->where($FOREIGN_KEY . ".id=" . $condition[$FOREIGN_KEY]);
                }
            }
        }

        return $query;
    }

    private function condition_formSelect_par_condition_Default($condition): array {
        $schema = $this->schema;
        $FOREIGN_KEYs = $schema->getFOREIGN_KEY();
        if (empty($FOREIGN_KEYs)) {
            return [];
        }
        $columnFOREIGN_KEY = [];
        foreach ($FOREIGN_KEYs as $FOREIGN_KEY) {
            $columnFOREIGN_KEY[] = "$FOREIGN_KEY.id as $FOREIGN_KEY" . "_id";
        }
        $Entitys = $this->prepareQuery((new QuerySQL())
                        ->select($columnFOREIGN_KEY)
                        ->from($schema->getNameTable())
                        ->join($schema->getFOREIGN_KEY())
                        ->where($condition)
                         ->prepareQuery());
        $Entity = $Entitys[0];
       
        /// si voir-table-68765868769698 => row note exist
     ///   if(empty(Tools::entitys_TO_array($Entity))){ return [];}
        
        $cond = [];
        foreach ($FOREIGN_KEYs as $FOREIGN_KEY) {
            $id = $FOREIGN_KEY . "_id";
            $cond[$FOREIGN_KEY] = $Entity->$id;
        }
        return $cond;
    }

}
