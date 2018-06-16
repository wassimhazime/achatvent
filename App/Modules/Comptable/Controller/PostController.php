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

        $this->getFile_Upload()->setPreffix($this->getPage());
        $insert = $this->getFile_Upload()->set($this->getRequest());
       

        $this->getModel()->setStatement($this->getPage());
        $intent = $this->getModel()->setData($insert);
        return $this->render("@show/show_item", ["intent" => $intent]);
    }

}
