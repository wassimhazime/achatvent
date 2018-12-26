<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\CRM\Model;

use App\AbstractModules\Model\AbstractModel;
use Kernel\INTENT\Intent_Form;
use Kernel\INTENT\Intent_Show;

/**
 * Description of Client
 *
 * @author wassim
 */
class Clients extends AbstractModel {

    public function dataChargeMultiSelectIndependent(array $id_FOREIGN_KEYs = array(), array $mode = self::MODE_SELECT_ALL_MASTER): array {
        return parent::dataChargeMultiSelectIndependent($id_FOREIGN_KEYs, $mode);
    }

    public function get_Charge_multiSelect($id_save, array $mode = self::MODE_SELECT_ALL_DEFAULT) {
        return parent::get_Charge_multiSelect($id_save, $mode);
    }

    public function get_Data_FOREIGN_KEY(array $id_FOREIGN_KEYs = array(), array $mode = self::MODE_SELECT_MASTER_NULL): array {
        return parent::get_Data_FOREIGN_KEY($id_FOREIGN_KEYs, $mode);
    }

    public function get_Data_FOREIGN_KEY__ID($id_save): array {
        return parent::get_Data_FOREIGN_KEY__ID($id_save);
    }

    public function get_id_FOREIGN_KEYs($id_save): array {
        return parent::get_id_FOREIGN_KEYs($id_save);
    }

    public function setData(array $data, $table_parent = "", $id_perent = 0) {
        parent::setData($data, $table_parent, $id_perent);
    }

    public function show(array $mode, $id = true): Intent_Show {
        
        return parent::show($mode, $id);
    }

    public function showAjax($mode, $id = true): array {
        
        return parent::showAjax($mode, $id);
    }

    public function show_in(array $mode, $rangeID): Intent_Show {
        
        return parent::show_in($mode, $rangeID);
    }

    public function show_styleForm($id, $modeselect = self::MODE_SELECT_ALL_DEFAULT): Intent_Form {
        
        return parent::show_styleForm($id, $modeselect);
    }

}
