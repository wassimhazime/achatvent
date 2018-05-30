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

namespace App\Modules\Ajax\Model;

use Kernel\INTENT\Intent;
use Kernel\Model\Model as kernelModel;
use TypeError;

class Model extends kernelModel
{

  

    public function showAjax($condition): Intent
    {
        if ($this->is_null()) {
            throw new TypeError(" is_null==> show ");
        }

        $intent = $this->getData()->select(Intent::MODE_SELECT_ALL_NULL, $condition);

        return $intent;
    }



}
