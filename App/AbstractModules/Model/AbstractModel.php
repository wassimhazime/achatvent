<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author wassime
 */

namespace App\AbstractModules\Model;

use Kernel\INTENT\Intent_Form;
use Kernel\INTENT\Intent_Show;
use Kernel\Model\Model;
use Kernel\Model\Query\QuerySQL;
use Kernel\Tools\Tools;

class AbstractModel extends Model {
    /*
     * ***************************************************************
     *  |form
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
     * @return Intent_Form
     */

    public function formSelect(): Intent_Form {

        //$schema = $this->getschema();
        //$schemaFOREIGN_KEY = new EntitysSchema();
        //$schemaFOREIGN_KEY->setNameTable($schema->getNameTable());
        //$schemaFOREIGN_KEY->setCOLUMNS_META($schema->getCOLUMNS_META(["Key" => "MUL"]));
        //$schemaFOREIGN_KEY->setFOREIGN_KEY($schema->getFOREIGN_KEY());
        //$META_data = $schemaFOREIGN_KEY->getCOLUMNS_META();
        $META_data = $this->get_Meta_FOREIGN_KEY();
        $Charge_data = [];
        $Charge_data ["select"] = $this->get_Data_FOREIGN_KEY();
        $Charge_data["multiselect"] = [];
        $Charge_data["PARENT"] = [];
        $Default_Data = [];
        return new Intent_Form($META_data, $Charge_data, $Default_Data);
    }

    /**
     * 
     * @param array $condition
     * @return Intent_Form
     */
    public function form(array $condition): Intent_Form {

        $META_data = $this->getschema()->getCOLUMNS_META();

        $Charge_data = [];
        $Charge_data ["select"] = $this->get_Data_FOREIGN_KEY($condition);
        $Charge_data["multiselect"] = $this->dataChargeMultiSelectIndependent($condition);
        $Charge_data["PARENT"] = [];
        $Default_Data = [];
        return new Intent_Form($META_data, $Charge_data, $Default_Data);
    }

    /**
     * 
     * @param array $conditionDefault
     * @return Intent_Form
     */
    public function formDefault(array $conditionDefault): Intent_Form {
        $schema = $this->getschema();

        // data Default
        $Entitys = $this->prepareQuery((new QuerySQL())
                        ->select($schema->select_all())
                        ->from($schema->getNameTable())
                        ->join($schema->getFOREIGN_KEY())
                        ->where($conditionDefault)
                        ->prepareQuery());


        if (!isset($Entitys[0])) {
            die("<h1>je ne peux pas insérer données  doublons ou vide </h1> ");
        }

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
        $Charge_data ["select"] = $this->get_Data_FOREIGN_KEY($conditionformSelect);
        $Charge_data["multiselect"] = $Entitys_CHILDRENs;
        $Charge_data["PARENT"] = [];
        $Default_Data = $Entity;
        return new Intent_Form($schema->getCOLUMNS_META(), $Charge_data, $Default_Data);
    }

    /**
     * 
     * @param type $id
     * @return Intent_Form
     */
    public function show_id($id): Intent_Form {
        return $this->formDefault(["{$this->getTable()}.id" => $id]);
    }

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
     * Intent_Show::mode 
     * @param array $mode
     * @param type $rangeID
     * @return Intent_Show
     */

    public function show_in(array $mode, $rangeID): Intent_Show {
        $schema = $this->getSchema();
        $Entitys = $this->select_in($mode, $rangeID);
        return new Intent_Show($schema, $Entitys, $mode);
    }

    /**
     * Intent_Show::mode
     * @param array $mode
     * @param type $id
     * @return Intent_Show
     */
    public function show(array $mode, $id = true): Intent_Show {

        $schema = $this->getSchema();
        $Entitys = $this->select($mode, $id);

        return new Intent_Show($schema, $Entitys, $mode);
    }

    /**
     * Intent_Show::mode
     * @param type $mode
     * @param type $id
     * @return array
     */
    public function showAjax($mode, $id = true): array {

        $entity = $this->select($mode, $id);

        return Tools::entitys_TO_array($entity);
    }

    /*
     * ***************************************************************
     *  |set data
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |

     */ ///****************************************************************////

   
    // save data
    public function setData(array $data,$table_parent="", $id_perent = 0) {


        if (isset($data) && !empty($data)) {
            if ($id_perent === 0) {
                if (!isset($data['id']) || $data['id'] == "") {
                    $id_parent = $this->insert($data);
                } else {
                    $id_parent = $this->update($data);
                }
            } else {
                $id_parent = $this->insert_inverse($data, $id_perent,$table_parent);
            }
            return ($id_parent);
        } else {
            die("rak 3aya9ti");
        }
    }

}
