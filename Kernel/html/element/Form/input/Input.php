<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\element\Form\input;

use Kernel\html\element\Form\input\Abstract_Input;
use Kernel\html\HTML;

/**
 * Description of Input
 *
 * @author wassime
 */
class Input extends Abstract_Input
{

    //put your code here
    public function builder()
    {
        $name = $this->name;
        $id_html = $this->id_html;
        $Default = $this->Default;
        $type = $this->type;
        $tag = HTML::TAG('input')
                ->setId($id_html)
                ->setType($type)
                ->setPlaceholder(str_replace("_", " ", str_replace("$", " ", $name)))
                ->setClass("  form-control input-sm ")
                ->setAtt('data-set_null="' . $this->null . '"  step="any" ')
                ->setValue($Default);


        if ($this->input['Type'] == "file") {
            if ($this->child != "[]") {
                $tag->setAtt('multiple ');
                $tag->setName($name . "[]");
            } else {
                $tag->setName($name . "_");
            }
        } else {
            $tag->setName($name . $this->child);
        }


        return $this->div($tag->builder());
    }
}
