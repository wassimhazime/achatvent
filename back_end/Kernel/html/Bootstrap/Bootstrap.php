<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace core\html\Bootstrap;

class Bootstrap
{

    public $ico_toggle;
    public $Dialog_modal_meta_div;
    public $Dialog_modal_header;
    public $Dialog_modal_footer;

    function __construct()
    {
        $this->ico_toggle='<span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span>';
    }

    public function createModal(
        $content,
        $id = 'myModal',
        $json = '',
        $title = '<h4 class="modal-title" id="myModalLabel">titre test</h4>',
        $modal_footer = ' <button type="button" class="btn btn-primary">Save changes</button>'
    ) {


        $header = '<div class="modal fade " id="'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        '.$title.'
      </div>
      <div id="dataJSON" class="hidden">
      '.$json.'
      </div>


      <div class="modal-body">
      

      ';
        
        ///$content

        $footer = '</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">&times;</button>
       '.$modal_footer.'
      </div>
    </div>
  </div>
</div>';

        return $header . $content . $footer;
    }
    
    
    public function createStyleTable($content)
    {
        $header='<table class="table table-hover table-bordered">';
      
              $footer=' </table>';
              return $header . $content . $footer;
    }

    public function createJumbotron($content, $idBTN = 'myModal')
    {
        $header = '<a  class="btn btn-warning whidden close ">'.$this->ico_toggle.'</a>
            <div class=" center-block jumbotron " id="wjumbotron" >

                <h1>Hello, world!</h1>

                   ';


                   $footer =
                           '

           <button  type="button" class="btn btn-primary btn-lg  " data-toggle="modal" data-target="#'.$idBTN.'">
             plus info
           </button>
           <a  class="btn btn-warning whidden "><span aria-hidden="true">&times;</span></a>
           </div>
';


        return $header . $content . $footer;
    }
}
