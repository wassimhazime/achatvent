<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\element\Form\input;

use Kernel\html\HTML;

/**
 * Description of Abstract_Input
 *
 * @author wassime
 */
abstract class Abstract_Input {

    protected $input = [];
    protected $name;
    protected $id_html;
    protected $Default;
    protected $type;
    protected $null;
    protected $lable = "";
    protected $styleGroup;
    protected $child;

    function __construct(array $input, string $styleGroup = "form-horizonta", string $child = "") {

        $this->child = $child;
        $this->name = $input['Field'];
        $this->id_html = $input['id_html'];

        if ($this->child !== "") {
            $this->name .= "_child";
            $this->id_html .= "_child";
        }
        $this->styleGroup = $styleGroup;
        $this->input = $input;
        $this->Default = $input['Default'];
        $this->type = $input['Type'];
        $this->null = $input['Null'];
        if ($this->type != "hidden") {
            $this->lable = str_replace("_", " ", str_replace("$", " ", $input['Field']));
            if ($this->null == "NO") {
                $this->lable .= ' <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ';
            }
        }
    }

    abstract function builder();

    protected function div($input, $badge = "") {
        if ($this->styleGroup === "form-horizonta") {
            return $this->form_horizonta($input, $badge);
        } elseif ($this->styleGroup === "form-inline") {
            return $this->form_inline($input, $badge);
        } elseif ($this->styleGroup === "form-table") {
            return $this->form_table($input, $badge);
        }
    }

    protected function form_horizonta($input, $badge = "") {
        $labelHTML = HTML::TAG('label')
                ->setClass("col-sm-3 control-label")
                ->setAtt(' style="text-align: left;"')
                ->setData($this->lable)
                ->setFor($this->name)
                ->builder();

        $inputHTML = HTML::TAG("div")
                ->setClass("col-sm-9")
                ->setData($input)
                ->builder();

        $div = HTML::TAG("div")
                ->setClass("form-group ")
                ->setData([$labelHTML, $inputHTML])
                ->builder();
        return $div;
    }

    protected function form_inline($input, $badge = "") {
        $labelHTML = HTML::TAG('label')
                ->setClass("control-label")
                ->setAtt(' style="text-align: left;"')
                ->setData($this->lable)
                ->setFor($this->name)
                ->builder();

        $inputHTML = HTML::TAG("div")
                ->setData($input)
                ->builder();

        $div = HTML::TAG("div")
                ->setClass("form-group ")
                ->setData([$labelHTML, $inputHTML])
                ->builder();
        return $div;
    }

    protected function form_table($input, $badge = "") {
        return ["label" => $this->lable, "input" => $input];
    }

}
