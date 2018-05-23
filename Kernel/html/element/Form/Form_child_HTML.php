<?php

namespace Kernel\html\element\Form;

use Kernel\html\element\Form\input\Readonly;
use Kernel\html\HTML;

class Form_child_HTML extends FormAbstract {

    protected $input = [];
    protected $input_PARENT = [];

    public function builder() {
        $form_grop_PARENT = [];
        $form_grop_child = [];
        foreach ($this->input_PARENT as $input) {

            $form_grop_PARENT[] = (new Readonly($input))->builder();
        }

        foreach ($this->input as $input) {
            $form_grop_child[] = $this->InputTage($input, "form-inline", "[]");
        }



        $parent = implode(" ", $form_grop_PARENT);

        $child = implode(" ", $form_grop_child);


        return $this->merge_form($parent, $child);
    }

    protected function merge_form(string $parent, string $child) {

        $panelchild =" ";
        $panelperent = '  ';


        return $panelchild . $panelperent;
    }

    protected function setInput($META_data, $Charge_data, $Default_Data = []) {
        /// charge input child
        $this->charge_input($META_data, $Charge_data);
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
