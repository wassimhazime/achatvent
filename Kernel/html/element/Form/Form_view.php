<?php

namespace Kernel\html\element\Form;

use Kernel\html\Components\Box_shadow;
use Kernel\html\Components\Panel;
use Kernel\html\element\Form\FormAbstract;
use Kernel\html\element\TableHTML;

class Form_view extends FormAbstract {

    public function builder() {
        $form_grop = [];

        foreach ($this->input as $input) {
            $name = $input['Field'];
            $title = str_replace("_", " ", str_replace("$", " ",$name));
            $body = $this->InputTage($input);
            $panel = (new Panel($title, $body))->builder();
            $icon = ' <span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span> ';
            $form_grop[] = ( new Box_shadow($icon, $panel, 8))->builder();
        }
        $content= implode(" ", $form_grop);
        
        return ( new Box_shadow("", $content, 16))->builder();
        
 
    }

    protected function setInput($META_data, $Charge_data, $Default_Data = []) {
        $this->charge_input($META_data, $Charge_data, $Default_Data);
        $this->charge_input_multiselect($Charge_data, $Default_Data);
    }

    private function charge_input_multiselect($Charge_data, $Default_Data) {

        foreach ($Charge_data["multiselect"] as $name_CHILDREN => $data) {
            $default = [];
            if (isset($Default_Data['DataJOIN'][$name_CHILDREN])) {
                $default = $Default_Data['DataJOIN'][$name_CHILDREN];
            }

            $this->input[$name_CHILDREN] = [
                "Field" => $name_CHILDREN,
                "Type" => "multiSelect",
                "id_html" => " ",
                "Null" => "YES",
                "Key" => "",
                "Default" => $default,
                "Extra" => "",
                "Data_load" => $data];
        }
    }

    protected function InputTage(array $input, string $styleGroup = "form-horizonta", string $child = "") {
        switch ($input['Type']) {

            case "multiSelect":

                if (isset($input["Default"][0])) {
                    $heads = [];
                    foreach ($input["Default"][0] as $key => $value) {
                        $head = str_replace("_", " ", str_replace("$", " ",$key));
                        $heads[] = $head;
                    }

                    $att = ' style="width:95% ; margin: auto ;" class="table table-striped table-bordered dt-responsive nowrap "';
                    $table= (new TableHTML())->builder( $heads, $input["Default"]);
                
                    return "<table $att >".$table."</table>";
                    }

            default:

                return $input['Default'];
        }
    }

}
