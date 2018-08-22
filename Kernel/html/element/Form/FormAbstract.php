<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\element\Form;

use Kernel\Conevert\SQL_HTML;
use Kernel\html\element\Form\input\Input;
use Kernel\html\element\Form\input\MultiSelect;
use Kernel\html\element\Form\input\Select;
use Kernel\html\element\Form\input\Textarea;
use Kernel\INTENT\Intent_Form;

/**
 * Description of FormAbstract
 *
 * @author wassime
 */
abstract class FormAbstract
{

    ///Conevert_TypeClomunSQL_to_TypeInputHTML
    protected $Conevert;
    protected $input = [];

    function __construct( Intent_Form $Intent_Form)
    {

        $META_data = $Intent_Form->getCOLUMNS_META();
        $Charge_data = $Intent_Form->getCharge_data();
        $Default_Data = $Intent_Form->getDefault_Data();

      
        //// change input
        $this->setInput($META_data, $Charge_data, $Default_Data);
    }

    protected function conevert(array $COLUMN_META, $sefix = "id_html_"): array
    {
        $type = $COLUMN_META['Type'];
        $id = $sefix . $COLUMN_META['Field'];
        $COLUMN_META['Type'] = SQL_HTML::getTypeHTML($type);
          $COLUMN_META['id_html'] = $id;
//        if (isset($this->Conevert[$type])) {
//           
//          // $COLUMN_META['Type'] = $this->Conevert[$type];
//          $COLUMN_META['id_html'] = $id;
//            
//        } else {
//            $COLUMN_META['Type'] = "text";
//            $COLUMN_META['id_html'] = " ";
//        }
        return $COLUMN_META;
    }

    protected function charge_input($META_data, $Charge_data, $Default_Data = [])
    {
        foreach ($META_data as $COLUMN_META) {
            $name = $COLUMN_META["Field"];

            // conevetr metadata sql to html (<input type="text" .....)
            $this->input[$name] = ($this->conevert($COLUMN_META));


            // set data on select input <option> ......
            if ($COLUMN_META["Key"] == "MUL") {
                $this->input[$name]["Data_load"] = $Charge_data["select"][$name];
            }

            /// set data si is on default
            if (isset($Default_Data[$name])) {
                $this->input[$name] ['Default'] = $Default_Data[$name];
            }
        }
    }

    protected function InputTage(array $input, string $styleGroup = "form-horizonta", string $child = "")
    {
        switch ($input['Type']) {
            case "textarea":
                $inputHTML = (new Textarea($input, $styleGroup, $child))->builder();
                break;
            case "select":
                $inputHTML = (new Select($input, $styleGroup, $child))->builder();
                break;
            case "multiSelect":
                $inputHTML = (new MultiSelect($input, $styleGroup, $child))->builder();
                break;

            default:
                $inputHTML = (new Input($input, $styleGroup, $child))->builder();
                break;
        }
        return $inputHTML;
    }

    abstract function builder();

    abstract protected function setInput($META_data, $Charge_data, $Default_Data = []);
}
