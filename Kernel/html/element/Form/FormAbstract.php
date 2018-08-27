<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\element\Form;

use Kernel\html\element\Form\input\Input;
use Kernel\html\element\Form\input\MultiSelect;
use Kernel\html\element\Form\input\Schema_Input_HTML;
use Kernel\html\element\Form\input\Select;
use Kernel\html\element\Form\input\Textarea;
use TypeError;
use function is_a;

/**
 * Description of FormAbstract
 *
 * @author wassime
 */
abstract class FormAbstract {

    protected $inputs = [];

    /**
     * 
     * @param array Schema_Input_HTML $inputs
     */
    function __construct(array $inputs) {

        $flag = $this->is_Array_Schema_Input($inputs);
        if (!$flag) {
            throw new TypeError("Schema_Input_HTML error => is not inputs type Schema_Input_HTML ");
        }
        $this->inputs = $inputs;
    }

    protected function InputTage(Schema_Input_HTML $input, string $styleGroup = "form-horizonta", string $child = "") {
       
        switch ($input->getType()) {
            case "textarea":
                $inputHTML = (new Textarea($input, $styleGroup, $child))->builder();
                break;
            case "select":
                $inputHTML = (new Select($input, $styleGroup, $child))->builder();
                break;
            case "mult_select":
                $inputHTML = (new MultiSelect($input, $styleGroup, $child))->builder();
                break;

            default:
                $inputHTML = (new Input($input, $styleGroup, $child))->builder();
                break;
        }
        return $inputHTML;
    }

    abstract function builder();

    /**
     * cheket type input 
     * @param array $inputs
     * @return boolean
     */
    private function is_Array_Schema_Input(array $inputs) {
        foreach ($inputs as $input) {
            if (!is_a($input, Schema_Input_HTML::class)) {
                return false;
            }
        }
        return true;
    }

}
