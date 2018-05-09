<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\INTENT;

use Kernel\Tools\Tools;

/**
 * Description of Intent_Form
 *
 * @author wassime
 */
class Intent_Form {

    private $META_data = [];
    private $Charge_data = [];
    private $Default_Data = [];

    function __construct($META_data, $Charge_data, $Default_Data) {

        $this->META_data = Tools::entitys_TO_array($META_data);
        
        $this->Charge_data = $Charge_data;
        
         if ($Default_Data != []) {
            $DefaultData = Tools::entitys_TO_array($Default_Data);
            $DefaultData["DataJOIN"] = $Default_Data->getDataJOIN();
        } else {
            $DefaultData = [];
        }
       $this->Default_Data = $DefaultData;
        
    }

    function getMETA_data() {
        return $this->META_data;
    }

    function getCharge_data() {
        return $this->Charge_data;
    }

    function getDefault_Data() {
        return $this->Default_Data;
    }

}
