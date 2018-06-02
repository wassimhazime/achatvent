<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Statistique\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class globalController extends AbstractController
{

    
    
    public function exec(): ResponseInterface
    {


            $st = $this->model->setStatement('statistique');
            $charge = $st->chargeDataSelect();
          
            var_dump($_GET);

            return $this->render("@statistique/global", ["charge" => $charge]);
    }
}
