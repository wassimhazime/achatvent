<?php

namespace Kernel\html\element\Form;
use Kernel\html\element\Form\input\Input;
use Kernel\html\element\Form\input\MultiSelect;
use Kernel\html\element\Form\input\Select;
use Kernel\html\element\Form\input\Textarea;
use Kernel\INTENT\Intent_Form;

use Kernel\html\element\Form\input\Readonly;
use Kernel\html\HTML;

class Form_child_HTML extends FormAbstract {

    protected $input = [];
    

    public function builder() {
       
        $form_grop_child = [];
            foreach ($this->input as $input) {
            $form_grop_child[] = $this->InputTage($input, "form-table", "[]");
        }
        
        
        $label=[];
        $input=[];
        foreach ($form_grop_child as $row) {
            $input[]=$row["input"];
            $label[]=$row["label"];
            
        }
        return $this->form_table($label, $input);
     
    }
    
    protected function form_table($label, $input) {
        $Thead=[];
        $Tbody=[];
        
          $Thead[]=' <thead>  <tr >';
        foreach ($label as $l) {
            $Thead[]='   <th class="text-center"> '.$l.'</th>';
        }
         $Thead[]='    <th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;"> </th>     </thead>';
       
       $Tbody[]=' <tbody id="content-child"> <tr   class="inputs-child">';
       foreach ($input as $b) {
             $Tbody[]='   <td > '. $b.' </td>';
        }
         $Tbody[]='     <td > <button class="delete btn btn-xs glyphicon glyphicon-trash row-remove" style="font-size: 16px ;    background-color: #f1a1c2;"> </button>
                                    </td> </tr> </tbody>';
         return implode(" ", $Thead).implode(" ", $Tbody);
    }


    protected function setInput($META_data, $Charge_data, $Default_Data = []) {
        /// charge input child
        $this->charge_input($META_data, $Charge_data);
        
       
    }



}
