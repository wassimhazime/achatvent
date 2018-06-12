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

class Model extends kernelModel
{

    public function setData($data)
    {
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

    public function delete($condition)
    {

        return  $this->get_setData()->delete($condition);

      
    }

    public function show_id($id)
    {
      //  $this->getData->is_id($id);
        
        return $this->getGui()->formDefault( ["{$this->getTable()}.id" => $id]);
    }


    public function show_in(array $mode, $condition=true) {
        if ($this->is_null()) {
            throw new TypeError(" is_null==> show ");
        }
        if($condition!==true){
       $condition=explode(",", $condition);
        }
        $intent = $this->getData()->select_in($mode,"{$this->getTable()}.id", $condition);
        return $intent;
    }
    public function show(array $mode, $condition=true) {
        if ($this->is_null()) {
            throw new TypeError(" is_null==> show ");
        }
        if($condition!==true){
            var_dump($condition);        die();
        $condition=    ["{$this->getTable()}.id" => $condition];
        }
        $intent = $this->getData()->select($mode, $condition);
        return $intent;
    }
    public function showAjax($condition)
    {
        if ($this->is_null()) {
            throw new TypeError(" is_null==> show ");
        }

        $intent = $this->getData()->select(Intent::MODE_SELECT_ALL_NULL, $condition);

        return $intent;
    }

    public function form( $conditon = "")
    {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }

        $intent = $this->getGui()->form( $conditon);


        return $intent;
    }

    public function formDefault($conditon)
    {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }

        $intent = $this->getGui()->formDefault( $conditon);


        return $intent;
    }

    public function formSelect()
    {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }
        $intent = $this->getGui()->formSelect();
        return $intent;
    }



}
