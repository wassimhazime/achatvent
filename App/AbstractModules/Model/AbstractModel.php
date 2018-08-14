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
//    public function formSelect(): Intent_Form {
//        $schema = $this->getschema();
//        $META_data = $schema->getCOLUMNS_META(["Key" => "MUL"]);
//        $Charge_data = $this->get_Data_FOREIGN_KEY();
//
//        $intent_form = new Intent_Form();
//        $intent_form->setMETA_data($META_data);
//        $intent_form->setCharge_data_select($Charge_data);
//
//
//        return $intent_form;
//    }

    /**
     * 
     * @param array $condition
     * @return Intent_Form
     */
//    public function form(array $condition): Intent_Form {
//
//        $META_data = $this->getschema()->getCOLUMNS_META();
//        $select = $this->get_Data_FOREIGN_KEY($condition);
//        $multiSelect = $this->dataChargeMultiSelectIndependent($condition);
//
//        $intent_form = new Intent_Form();
//        $intent_form->setMETA_data($META_data);
//        $intent_form->setCharge_data_select($select);
//        $intent_form->setCharge_data_multiSelect($multiSelect);
//
//        return $intent_form;
//    }

    /**
     * 
     * @param array $conditionDefault
     * @return Intent_Form
     */
    public function formDefault($id, $modeselect = Intent_Show::MODE_SELECT_ALL_MASTER): Intent_Form {


        $Entitys = $this->find_by_id($id, $modeselect);
        if ($Entitys->is_Null()) {
            die("<h1>donnees vide car je ne peux pas insérer données  doublons ou vide </h1> ");
        }

        $intent_Form = new Intent_Form();
        $intent_Form->setDefault_Data($Entitys);
        $intent_Form->setCharge_data_select($this->get_Data_FOREIGN_KEY__ID($id));
        $intent_Form->setCharge_data_multiSelect($this->get_Charge_multiSelect($id, $modeselect));
        $intent_Form->setCOLUMNS_META($this->getschema()->getCOLUMNS_META());

        return $intent_Form;
    }

    /**
     * 
     * @param type $id
     * @return Intent_Form
     */
    public function show_id($id): Intent_Form {
        return $this->formDefault($id);
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

    public function setData(array $data, $table_parent = "", $id_perent = 0) {


        if (isset($data) && !empty($data)) {
            if ($id_perent === 0) {
                if (!isset($data['id']) || $data['id'] == "") {
                    $id_parent = $this->insert_table_Relation($data);
                } else {
                    $id_parent = $this->update($data);
                }
            } else {
                $id_parent = $this->insert_tableChilde_Relation($data, $id_perent, $table_parent);
            }
            return ($id_parent);
        } else {
            die("rak 3aya9ti");
        }
    }

}
