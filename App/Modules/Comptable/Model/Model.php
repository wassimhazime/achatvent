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
        if ($this->is_null) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }
        if (isset($data) && !empty($data)) {
          

            if ($data['id'] == "") {
                $id_parent = $this->setData->insert($data, Intent::MODE_INSERT);
            } else {
                $id_parent = $this->setData->update($data, Intent::MODE_UPDATE);
            }
            return $this->show_id($id_parent);
        } else {
            die("rak 3aya9ti");
        }
    }

    public function delete($condition)
    {

        $intent = $this->setData->delete($condition);

        return $intent;
    }

    public function show_id($id)
    {
        return $this->gui->formDefault( ["{$this->table}.id" => $id]);
    }

    public function show(array $mode, $condition)
    {
        if ($this->is_null) {
            throw new TypeError(" is_null==> show ");
        }
        $intent = $this->getData->select($mode, $condition);
        return $intent;
    }

    public function showAjax($condition)
    {
        if ($this->is_null) {
            throw new TypeError(" is_null==> show ");
        }

        $intent = $this->getData->select(Intent::MODE_SELECT_ALL_NULL, $condition);

        return $intent;
    }

    public function form( $conditon = "")
    {
        if ($this->is_null) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }

        $intent = $this->gui->form( $conditon);


        return $intent;
    }

    public function formDefault($conditon = "")
    {
        if ($this->is_null) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }

        $intent = $this->gui->formDefault( $conditon);


        return $intent;
    }

    public function formSelect()
    {
        if ($this->is_null) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }
        $intent = $this->gui->formSelect();
        return $intent;
    }



}
