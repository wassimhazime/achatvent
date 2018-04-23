<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Comptable\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostController extends AbstractController {

    public function exec(): ResponseInterface {
       
        $this->File_Upload->setPreffix($this->page);
        $insert = $this->File_Upload->set($this->request);
        $this->model->setStatement($this->page);
        $msg = $this->model->setData($insert);
        
        $msghtml = $this->FactoryTAG->showinfo($msg);  //twig
       
        
        return $this->render("@show/show_item", ["message" => $msghtml]);
        
    }

}
