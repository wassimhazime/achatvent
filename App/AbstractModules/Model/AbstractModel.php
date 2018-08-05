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

use Kernel\INTENT\Intent;
use Kernel\INTENT\Intent_Form;
use Kernel\Model\Model;
use Kernel\Tools\Tools;
use function explode;

class AbstractModel extends Model {

    public function showAjax($mode, $condition): array {

        $intent = $this->select($mode, $condition);
        $entity = ($intent->getEntitysDataTable());
        return Tools::entitys_TO_array($entity);
    }

    // save data
    public function setData($data, $id_perent = 0) {

        if (isset($data) && !empty($data)) {
            if ($id_perent === 0) {
                if (!isset($data['id']) || $data['id'] == "") {
                    $id_parent = $this->insert($data, Intent::MODE_INSERT);
                } else {
                    $id_parent = $this->update($data, Intent::MODE_UPDATE);
                }
            } else {
                $id_parent = $this->insert_inverse($data, $id_perent, Intent::MODE_INSERT);
            }
            return ($id_parent);
        } else {
            die("rak 3aya9ti");
        }
    }

    public function show(array $mode, $condition = true): Intent {

        if ($condition !== true) {
            $condition = ["{$this->getTable()}.id" => $condition];
        }
        $intent = $this->select($mode, $condition);
        return $intent;
    }

    public function show_in(array $mode, $condition = true): Intent {

        if ($condition !== true) {
            $condition = explode(",", $condition);
        }
        $intent = $this->select_in($mode, "{$this->getTable()}.id", $condition);
        return $intent;
    }

    public function show_id($id): Intent_Form {
        return $this->formDefault(["{$this->getTable()}.id" => $id]);
    }

}
