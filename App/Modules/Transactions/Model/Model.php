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

namespace App\Modules\Transactions\Model;

use Kernel\INTENT\Intent;
use Kernel\Model\Model as kernelModel;
use TypeError;

class Model extends kernelModel {

    public function setData($data, $id_perent = 0) {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }
        if (isset($data) && !empty($data)) {


            if ($id_perent === 0) {
                if ($data['id'] == "") {

                    $id_parent = $this->get_setData()->insert($data, Intent::MODE_INSERT);
                    return ($id_parent);
                } else {

                    $id_parent = $this->get_setData()->update($data, Intent::MODE_UPDATE);

                    return ($id_parent);
                }
            } else {
                $id_parent = $this->get_setData()->insert_inverse($data, $id_perent, Intent::MODE_INSERT);
                return ($id_parent);
            }
        } else {
            die("rak 3aya9ti");
        }
    }

    public function find_by_id($id): array {
        return $this->getData()->find_by_id($id);
    }

    public function delete($condition) {

        $intent = $this->get_setData()->delete($condition);

        return $intent;
    }

    public function show(array $mode, $condition) {
        if ($this->is_null()) {
            throw new TypeError(" is_null==> show ");
        }
        $intent = $this->getData()->select($mode, $condition);
        return $intent;
    }

    public function showAjax($condition) {
        if ($this->is_null()) {
            throw new TypeError(" is_null==> show ");
        }

        $intent = $this->getData()->select(Intent::MODE_SELECT_ALL_NULL, $condition);

        return $intent;
    }

    public function show_id($id) {
        return $this->getGui()->formDefault(["{$this->table}.id" => $id]);
    }

    public function form($conditon = "") {
        if ($this->is_null()) {

            throw new TypeError(" set table ==> call function setStatement() ");
        }

        $intent = $this->getGui()->form($conditon);


        return $intent;
    }

    public function formDefault($conditon = "") {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }

        $intent = $this->getGui()->formDefault($conditon);


        return $intent;
    }

    public function formSelect() {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }

        $intent = $this->getGui()->formSelect();
        return $intent;
    }

    public function formChild(array $dataparent) {

        $intent = $this->getGui()->formChild($dataparent);


        return $intent;
    }

}
