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
        var_dump($insert);

        $this->model->setStatement($this->page);
        $intent = $this->model->setData($insert);
        return $this->render("@show/show_item", ["intent" => $intent]);
    }

}
