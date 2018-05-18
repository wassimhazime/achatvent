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
    protected $lable;
    
    protected $styleGroup;
      protected $child;

    function __construct(array $input, string $styleGroup = "form-horizonta",string $child="") {
        
        $this->child = $child;
        $this->styleGroup = $styleGroup;
      
        
        $this->name = $input['Field'];
        $this->input = $input;
        
        $this->id_html = $input['id_html'];
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

    abstract function builder(): string;

    protected function div($input, $badge = "") {
        if ($this->styleGroup === "form-horizonta") {
            $labelHTML = HTML::TAG('label')
                    ->setClass("col-sm-2 control-label")
                    ->setAtt(' style="text-align: left;"')
                    ->setData($this->lable)
                    ->setFor($this->name)
                    ->builder();

            $inputHTML = HTML::TAG("div")
                    ->setClass("col-sm-8")
                    ->setData($input)
                    ->builder();
        } elseif ($this->styleGroup === "form-inline") {
            $labelHTML = HTML::TAG('label')
                    ->setClass("control-label")
                    ->setAtt(' style="text-align: left;"')
                    ->setData($this->lable)
                    ->setFor($this->name)
                    ->builder();

            $inputHTML = HTML::TAG("div")
                    
                    ->setData($input)
                    ->builder();
        }
        $div = HTML::TAG("div")
                ->setClass("form-group ")
                ->setData([$labelHTML, $inputHTML])
                ->builder();



        return $div;
    }

}
