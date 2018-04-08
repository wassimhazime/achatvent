<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Base_Donnee;

use Kernel\INTENT\Intent;
use Kernel\Model\Base_Donnee\DataBase;
use Kernel\Model\Base_Donnee\Schema;
use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Entitys\EntitysSchema;
use Kernel\Model\Query\QuerySQL;

/**
 * Description of FORM
 *
 * @author wassime
 */
class FORM extends DataBase
{

    private $shema;

    public function __construct($PathConfigJsone, $table)
    {

        $this->shema = new Schema($PathConfigJsone);

        parent::__construct($PathConfigJsone, new EntitysDataTable(), $this->shema->getschema($table));
    }

    ////////////////////////////////////////////////////////////////////////////////
    public function formSelect(array $mode): Intent
    {

        $schema = $this->entitysSchema;
        // data form
        /// charge select input
        $Entitys_FOREIGNs = $this->datachargeselect();
        $data = [
            "FOREIGN_KEYs" => $Entitys_FOREIGNs, "CHILDRENs" => [], "Default" => [],
        ];
        // schem form
        /// new EntitysSchema pour form select
        $schemaFOREIGN_KEY = new EntitysSchema();
        $schemaFOREIGN_KEY->setNameTable($schema->getNameTable());
        $schemaFOREIGN_KEY->setCOLUMNS_META($schema->getCOLUMNS_META(["Key" => "MUL"]));
        $schemaFOREIGN_KEY->setFOREIGN_KEY($schema->getFOREIGN_KEY());


        return new Intent($schemaFOREIGN_KEY, $data, $mode);
    }

    public function form(array $mode, $condition): Intent
    {
        $schema = $this->entitysSchema;
        // data form
        /// charge select input
        $Entitys_FOREIGNs = $this->datachargeselect($condition);
//// charge multi select
        $Entitys_CHILDRENs = $this->dataChargeMultiSelectIndependent($condition);

        $data = ["FOREIGN_KEYs" => $Entitys_FOREIGNs,
            "CHILDRENs" => $Entitys_CHILDRENs,
            "Default" => []];


        return new Intent($schema, $data, $mode);
    }

    public function formDefault(array $mode, $conditionDefault): Intent
    {
        $schema = $this->entitysSchema;
        // data Default
        $Entitys = $this->query((new QuerySQL())
                        ->select($schema->select_all())
                        ->from($schema->getNameTable())
                        ->join($schema->getFOREIGN_KEY())
                        ->where($conditionDefault));
        $Entity = $Entitys[0];
        $conditionformSelect = $this->condition_formSelect_par_condition_Default($conditionDefault);
/// charge select input
        $Entitys_FOREIGNs = $this->datachargeselect($conditionformSelect);
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
        $data = ["FOREIGN_KEYs" => $Entitys_FOREIGNs, "CHILDRENs" => $Entitys_CHILDRENs, "Default" => [$Entity]];

        return new Intent($schema, $data, $mode);
    }

    ///////////////////////////////////////////////////////////////////


    private function datachargeselect(array $condition = [])
    {
        $schema = $this->entitysSchema;

        $nameTable_FOREIGNs = $schema->getFOREIGN_KEY();
        /// charge select input
        $Entitys_FOREIGNs = [];
        foreach ($nameTable_FOREIGNs as $nameTable_FOREIGN) {
            $schem_Table_FOREIGN = $this->shema->getschema($nameTable_FOREIGN);

            $querydataCharge = new QuerySQL();

            $querydataCharge->select($schem_Table_FOREIGN->select_master())
                    ->from($schem_Table_FOREIGN->getNameTable())
                    ->join($schem_Table_FOREIGN->getFOREIGN_KEY());
            if (!empty($condition)) {
                $querydataCharge->where($nameTable_FOREIGN . ".id=" . $condition[$nameTable_FOREIGN]);
            }


            $Entitys_FOREIGNs[$nameTable_FOREIGN] = $this->query($querydataCharge);
        }
        return $Entitys_FOREIGNs;
    }

    private function dataChargeMultiSelectIndependent(array $condition = [])
    {

        $schema = $this->entitysSchema;
        $nameTable_CHILDRENs = $schema->get_table_CHILDREN();

        $Entitys_CHILDRENs = [];

        foreach ($nameTable_CHILDRENs as $table_CHILDREN) {
            $schem_Table_CHILDREN = $this->shema->getschema($table_CHILDREN);
            $FOREIGN_KEY_CHILDRENs = $schem_Table_CHILDREN->getFOREIGN_KEY();

            $querydataCharge = new QuerySQL();

            $querydataCharge->select($schem_Table_CHILDREN->select_NameTable())
                    ->from($schem_Table_CHILDREN->getNameTable())
                    ->join($FOREIGN_KEY_CHILDRENs)
                    ->independent($schema->getNameTable());

            $query = $this->query_enfant_lier_formSelect($querydataCharge, $condition, $FOREIGN_KEY_CHILDRENs);
            $Entitys_CHILDRENs[$table_CHILDREN] = $this->query($query);
        }

        return $Entitys_CHILDRENs;
    }

    private function dataChargeMultiSelectDependent($tablechild, array $condition)
    {
        $schema = $this->entitysSchema;
        $schem_Table_CHILDREN = $this->shema->getschema($tablechild);
        return $this->query((
                                new QuerySQL())
                                ->select($schem_Table_CHILDREN->select_NameTable())
                                ->from($schema->getNameTable())
                                ->join($tablechild, " INNER ", true)
                                ->where($condition));
    }

    private function query_enfant_lier_formSelect(QuerySQL $query, array $condition, array $FOREIGN_KEY_CHILDRENs)
    {


        if (!empty($condition) and ! empty($FOREIGN_KEY_CHILDRENs)) {
            foreach ($FOREIGN_KEY_CHILDRENs as $FOREIGN_KEY) {
                if (isset($condition[$FOREIGN_KEY])) {
                    $query->where($FOREIGN_KEY . ".id=" . $condition[$FOREIGN_KEY]);
                }
            }
        }

        return $query;
    }

    private function condition_formSelect_par_condition_Default($condition): array
    {
        $schema = $this->entitysSchema;
        $FOREIGN_KEYs = $schema->getFOREIGN_KEY();
        if (empty($FOREIGN_KEYs)) {
            return [];
        }
        $columnFOREIGN_KEY = [];
        foreach ($FOREIGN_KEYs as $FOREIGN_KEY) {
            $columnFOREIGN_KEY[] = "$FOREIGN_KEY.id as $FOREIGN_KEY" . "_id";
        }
        $Entitys = $this->query((new QuerySQL())
                        ->select($columnFOREIGN_KEY)
                        ->from($schema->getNameTable())
                        ->join($schema->getFOREIGN_KEY())
                        ->where($condition));
        $Entity = $Entitys[0];
        $cond = [];
        foreach ($FOREIGN_KEYs as $FOREIGN_KEY) {
            $id = $FOREIGN_KEY . "_id";
            $cond[$FOREIGN_KEY] = $Entity->$id;
        }
        return $cond;
    }
}
