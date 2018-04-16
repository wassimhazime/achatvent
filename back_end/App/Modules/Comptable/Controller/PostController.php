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

class PostController extends Controller {

    public function exec(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {

        $route = $this->router->match($request);
        $params = $route->getParams();
        $page = $params["controle"];



        if ($page == "statistique") {
            $query = $request->getParsedBody();


            $st = $this->model->setStatement('statistique');




            $raport = ($st->statistique_pour($query));

            $response->getBody()->write($raport);

            return $response;
        }




        $this->File_Upload->setPreffix($page);
        $insert = $this->File_Upload->set($request);
        $this->model->setStatement($page);
        $msg = $this->model->setData($insert);
        $msghtml = $this->FactoryTAG->message($msg);  //twig
        // $data = $this->renderer->render("@achat/message_ajouter", ["message" => $msghtml]);
        $response->getBody()->write($msghtml);
        return $response;
    }

}
