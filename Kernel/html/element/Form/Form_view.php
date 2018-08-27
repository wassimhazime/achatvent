<?php

namespace Kernel\html\element\Form;

use Kernel\html\Components\Box_shadow;
use Kernel\html\Components\Panel;
use Kernel\html\element\Form\FormAbstract;
use Kernel\html\element\TableHTML;
use Kernel\INTENT\Schema_Input_HTML;
use function implode;
use function str_replace;

class Form_view extends FormAbstract {

    public function builder() {
        $form_grop = [];

        foreach ($this->inputs as $input) {
            $name = $input->getName();
            $title = str_replace("_", " ", str_replace("$", " ", $name));
            $body = $this->InputTage($input);
            $panel = (new Panel($title, $body))->builder();
            $icon = ' <span class="glyphicon glyphicon-pushpin" aria-hidden="true"></span> ';
            $form_grop[] = ( new Box_shadow($icon, $panel, 8))->builder();
        }
        $content = implode(" ", $form_grop);

        return ( new Box_shadow("", $content, 16))->builder();
    }

  

    protected function InputTage(Schema_Input_HTML $input, string $styleGroup = "form-horizonta", string $child = "") {
       
        switch ($input->getType()) {
            case "multiSelect":
                if (isset($input->getDefault()[0])) {
                    $heads = [];
                    foreach ($input->getDefault()[0] as $key => $value) {
                        $head = str_replace("_", " ", str_replace("$", " ", $key));
                        $heads[] = $head;
                    }

                    $att = ' style="width:95% ; margin: auto ;" class="table table-striped table-bordered dt-responsive nowrap "';
                    $table = (new TableHTML())->builder($heads, $input->getDefault());

                    return "<table $att >" . $table . "</table>";
                }

            default:
                return $input->getDefault();
        }
    }

}
