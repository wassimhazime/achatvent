<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Transactions\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */
use Kernel\INTENT\Intent;
use Psr\Http\Message\ResponseInterface;

class PostController extends AbstractController {

    public function exec(): ResponseInterface {

        $this->File_Upload->setPreffix($this->page);
        $insert = $this->File_Upload->set($this->request);

        $this->model->setStatement($this->page);
       $id_parent = $this->model->setData($insert); // formnext Raison sociale
       
       $dataperant= $this->model->find_by_id($id_parent); /// show data set


        $page = substr($this->page, 0, -1); // childe achats => achat
        
        $this->model->setStatement($page);
       
        
        
        $intent = $this->model->formChild($dataperant);
        
        return $this->render("@T_traitement/ajouter_child", ["intent" => $intent]);
        
    }

}
