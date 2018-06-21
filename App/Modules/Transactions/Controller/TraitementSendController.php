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

class TraitementSendController extends AbstractController {

    public function exec(): ResponseInterface {

        var_dump($_POST);
        
        
        
        die();
        $this->getFile_Upload()->setPreffix($this->getPage());
        $insert = $this->getFile_Upload()->set($this->getRequest());

        $this->getModel()->setStatement($this->getPage());
        $id_parent = $this->getModel()->setData($insert); // formnext Raison sociale

        $dataperant = $this->getModel()->find_by_id($id_parent); /// show data set


        $page = substr($this->getPage(), 0, -1); // childe achats => achat

        $this->getModel()->setStatement($page);



        $intent = $this->getModel()->formChild($dataperant);

        return $this->render("@TransactionsTraitement/ajouter_child", ["intent" => $intent]);
    }

}
