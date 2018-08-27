<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\element\Form\input;

use Kernel\html\HTML;
use Kernel\INTENT\Schema_Form;
use Kernel\html\element\Form\input\Schema_Input_HTML;
use function str_replace;

/**
 * Description of Abstract_Input
 *
 * @author wassime
 */
abstract class Abstract_Input {

    /**
     *
     * @var Schema_Form
     */
    protected $input;
    protected $name;
    protected $id_html;
    protected $Default;
    protected $type;
    protected $null;
    protected $lable = "";
    protected $styleGroup;
    protected $child;

    function __construct(Schema_Input_HTML $input, string $styleGroup = "form-horizonta", string $child = "") {

        $this->child = $child;
        $this->name = $input->getName();
        $this->id_html = $input->getId_html();

        if ($this->child !== "") {
            $this->name .= "_child";
            $this->id_html .= "_child";
        }
        $this->styleGroup = $styleGroup;
        $this->input = $input;
        $this->Default = $input->getDefault();
        $this->type = $input->getType();
        $this->null = $input->getIsNull();
        if ($this->type != "hidden") {
            $this->lable = str_replace("_", " ", str_replace("$", " ", $input->getName()));
            if (!$this->null) {
                $this->lable .= ' <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ';
            }
        }
    }

    abstract function builder();

    protected function div($input, $badge = "") {
        if ($this->styleGroup === "form-horizonta") {
            return $this->style_form_horizonta($input, $badge);
        } elseif ($this->styleGroup === "form-inline") {
            return $this->style_form_inline($input, $badge);
        } elseif ($this->styleGroup === "form-table") {
            return $this->style_form_table($input, $badge);
        }
    }

    protected function style_form_horizonta($input, $badge = "") {
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

    protected function style_form_inline($input, $badge = "") {
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

    protected function style_form_table($input, $badge = "") {
        return ["label" => $this->lable, "input" => $input];
    }

}
