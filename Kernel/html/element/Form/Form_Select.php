<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\element\Form;

/**
 * Description of Form_Select
 *
 * @author wassime
 */
class Form_Select extends FormAbstract {

    public function builder() {
        $form_grop = [];

        foreach ($this->input as $input) {
            $form_grop[] = $this->InputTage($input);
        }
        return implode(" ", $form_grop);
    }

    protected function setInput($META_data, $Charge_data, $Default_Data = []) {
        $this->charge_input($META_data, $Charge_data, $Default_Data);
    }

}
