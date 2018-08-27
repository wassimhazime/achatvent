<?php

namespace Kernel\html\element\Form;

class FormHTML extends FormAbstract {

    public function builder() {
        $form_grop = [];

        foreach ($this->inputs as $input) {
            $form_grop[] = $this->InputTage($input);
        }
        return implode(" ", $form_grop);
    }



   
}
