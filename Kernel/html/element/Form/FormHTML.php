<?php

namespace Kernel\html\element\Form;

class FormHTML extends FormAbstract {

    public function builder() {
        $form_grop = [];

        foreach ($this->input as $input) {
            $form_grop[] = $this->InputTage($input);
        }
        return implode(" ", $form_grop);
    }

    protected function setInput($META_data, $Charge_data, $Default_Data = []) {

        $this->charge_input_multiselect($Charge_data, $Default_Data);

        $this->charge_input($META_data, $Charge_data, $Default_Data);
    }

    private function charge_input_multiselect($Charge_data, $Default_Data) {

        $inputnames = array_keys(array_merge($Charge_data["multiselect"], $Default_Data["DataJOIN"]));


        foreach ($inputnames as $name_CHILDREN) {

            $default = [];
            if (isset($Default_Data['DataJOIN'][$name_CHILDREN])) {
                $default = $Default_Data['DataJOIN'][$name_CHILDREN];
            }

            $data_load = [];
            if (isset($Charge_data["multiselect"][$name_CHILDREN])) {
                $data_load = $Charge_data["multiselect"][$name_CHILDREN];
            }

            $this->input[$name_CHILDREN] = [
                "Field" => $name_CHILDREN,
                "Type" => "multiSelect",
                "id_html" => " ",
                "Null" => "YES",
                "Key" => "",
                "Default" => $default,
                "Extra" => "",
                "Data_load" => $data_load];
        }
    }

}
