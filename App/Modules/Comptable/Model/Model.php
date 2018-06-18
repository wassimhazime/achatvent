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

namespace App\Modules\Comptable\Model;

use Kernel\INTENT\Intent;
use Kernel\Model\Model as kernelModel;
use TypeError;

class Model extends kernelModel {

    public function setData($data) {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }
        if (isset($data) && !empty($data)) {


            if ($data['id'] == "") {

                $id_parent = $this->get_setData()->insert($data, Intent::MODE_INSERT);
            } else {
                $id_parent = $this->get_setData()->update($data, Intent::MODE_UPDATE);
            }
            return $this->show_id($id_parent);
        } else {
            die("rak 3aya9ti");
        }
    }

    
 

   

    public function show(array $mode, $condition = true) {
        if ($this->is_null()) {
            throw new TypeError(" is_null==> show ");
        }
        if ($condition !== true) {
            var_dump($condition);
            die();
            $condition = ["{$this->getTable()}.id" => $condition];
        }
        $intent = $this->getData()->select($mode, $condition);
        return $intent;
    }

 

   

    

}
