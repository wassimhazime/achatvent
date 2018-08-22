<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Renderer\Twig_Extension;

use Kernel\html\ConfigExternal;
use Kernel\html\element\Form\Form_child_HTML;
use Kernel\html\element\Form\Form_Select;
use Kernel\html\element\Form\Form_view;
use Kernel\html\element\Form\FormHTML;
use Kernel\html\element\Form\View_Data_Parent;
use Kernel\INTENT\Intent_Form;
use \Twig_Extension;
use \Twig_SimpleFunction;

/**
 * Description of Form
 *
 * @author wassime
 */
class Form extends Twig_Extension
{

    private $ConfigExternal;
    private $conevert;

    public function __construct($PathConfigJsone)
    {
        $this->ConfigExternal = new ConfigExternal($PathConfigJsone);
        ///Conevert_TypeClomunSQL_to_TypeInputHTML
        $this->conevert = ($this->ConfigExternal->getConevert());
    }

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction("form", [$this, "form"], ['is_safe' => ['html']]),
            new Twig_SimpleFunction("form_child", [$this, "form_child"], ['is_safe' => ['html']]),
            new Twig_SimpleFunction("form_select", [$this, "form_select"], ['is_safe' => ['html']]),
            new Twig_SimpleFunction("Form_view", [$this, "Form_view"], ['is_safe' => ['html']]),
           // new Twig_SimpleFunction("View_Data_Parent", [$this, "View_Data_Parent"], ['is_safe' => ['html']]),
        ];
    }

    public function form(Intent_Form $Intent_Form)
    {       
        $formhtml = new FormHTML( $Intent_Form);
        
        return $formhtml->builder();
    }

    public function form_select(Intent_Form $Intent_Form)
    {
        $formhtml = new Form_Select( $Intent_Form);
        return $formhtml->builder();
    }
    public function View_Data_Parent(Intent_Form $Intent_Form)
    {
        $formhtml = new View_Data_Parent( $Intent_Form);
        return $formhtml->builder();
    }

    public function form_child(Intent_Form $Intent_Form)
    {
        $formhtml = new Form_child_HTML( $Intent_Form);
        return $formhtml->builder();
    }

    public function Form_view(Intent_Form $Intent_Form)
    {
        $formhtml = new Form_view( $Intent_Form);
        return $formhtml->builder();
    }
}
