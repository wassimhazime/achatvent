<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\element\Form;
namespace Kernel\html\element\Form;

use Kernel\html\element\Form\input\Readonly;
use Kernel\html\HTML;

class View_Data_Parent extends FormAbstract{


    protected $input_PARENT = [];

    public function builder() {
        $form_grop_PARENT = [];
     
        foreach ($this->input_PARENT as $input) {
           $form_grop_PARENT[] = (new Readonly($input))->builder();
        }
     return  implode(" ", $form_grop_PARENT);

    }

   

    protected function setInput($META_data, $Charge_data, $Default_Data = []) {
  
        ///charge input show parent
        $this->charge_input_PARENT($Charge_data);
    }

    protected function charge_input_PARENT($Charge_data) {
        foreach ($Charge_data["PARENT"] as $key => $value) {
            $this->input_PARENT ["parent_" . $key] = [
                'Field' => "parent_" . $key,
                'Type' => 'text',
                'Null' => 'NO',
                'Key' => 'PRI',
                'Default' => $value,
                'Extra' => '',
                'id_html' => 'id_html_id '];
        }
    }

}
