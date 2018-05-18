<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\element\Form\input;

/**
 * Description of Readonly
 *
 * @author wassime
 */
use Kernel\html\HTML;
class Readonly extends Abstract_Input {

    //put your code here
    public function builder(): string {
        $name = $this->name;
        $id_html = $this->id_html;
        $Default = $this->Default;
        $type = $this->type;
        $label = str_replace("parent", " ", str_replace("$", " ",  str_replace("_", " ", $name)));;
        

        $inputehiddenperent= HTML::TAG('input')
                ->setClass(" form-control ")
                ->setId($id_html)
                ->setType("hidden")
                 ->setValue($Default)
                ->setName($name )
                ->builder()
                ;


        
        
     $show='    <li class="list-group-item" style="    max-width: 278px;">
    <span class="badge">'."   ".$Default.'</span>
   '.$label.'
  </li>'
           ;


     return $inputehiddenperent.$show;
       
    }

    
    
    
}
