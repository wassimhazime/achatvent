<?php

namespace Kernel\html\element\Form;

use function implode;

class Form_child_HTML extends FormAbstract
{

    protected $input = [];

    public function builder()
    {
        $label = [];
        $input = [];
        foreach ($this->input as $inputGenerete) {
            $row = $this->InputTage($inputGenerete, "form-table", "[]");
            $input[] = $row["input"];
            $label[] = $row["label"];
        }

        return $this->form_table($label, $input);
    }

    protected function form_table($label, $input)
    {
        $Thead = [];
        $Tbody = [];

        $Thead[] = ' <thead>  <tr >';
        foreach ($label as $l) {
            $Thead[] = '   <th class="text-center"> ' . $l . '</th>';
        }
        $Thead[] = '    <th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;"> </th>     </thead>';

        $Tbody[] = ' <tbody id="content-child"> <tr   class="inputs-child">';
        foreach ($input as $b) {
            $Tbody[] = '   <td > ' . $b . ' </td>';
        }
        $Tbody[] = '     <td > <button class="delete btn btn-xs glyphicon glyphicon-trash row-remove" style="font-size: 16px ;    background-color: #f1a1c2;"> </button>
                                    </td> </tr> </tbody>';
        return implode(" ", $Thead) . implode(" ", $Tbody);
    }

    protected function setInput($META_data, $Charge_data, $Default_Data = [])
    {
        /// charge input child
        $this->charge_input($META_data, $Charge_data);
    }
}
