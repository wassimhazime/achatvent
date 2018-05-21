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


        $deleterow = HTML::TAG("a")->setAtt('href="#"')->setClass("delete")->setData("delete")->builder();
        $divrom = HTML::TAG('div')->setClass("inputs-child row")->setAtt(' style="margin: 0px" ')->setData($child . $deleterow)->builder();
        $divcontent = HTML::TAG("div")->setClass("content-child")->setAtt('style="margin: 0px"')->setData($divrom)->builder();
        $p = '<div class="jumbotron" style="padding-left: 21px;">
  <h1>Modification du document </h1>
  <ul class="list-group">
  ' . $parent . '
      </ul>
  <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>
</div>';


        return $p . $divcontent;
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
