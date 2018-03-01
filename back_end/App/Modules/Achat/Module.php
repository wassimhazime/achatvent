<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Module
 *
 * @author wassime
 */

namespace App\Modules\Achat;

use Kernel\html\FactoryTAG;
use Kernel\INTENT\Intent;
use Kernel\Model\Model;
use Kernel\Renderer\TwigRenderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Module {

    public $model;
    public $FactoryTAG;
    public $renderer;

    public function addPathRenderer($renderer, $pathModules) {
        $renderer->addPath($pathModules . "Achat" . D_S . "views", "achat");
    }

    public function addRoute($router) {

        // $router->get("/{controle:[a-z]+}", [$this, "MVC"], "blog.strj");
        $router->get("/achat/{controle:[a-z\_]+}", [$this, "MVC"], "achat.get");
        $router->get("/{controle:[a-z\_]*}", [$this, "MVC"], "achat");

        $router->post("/achat/{controle:[a-z\_]+}", [$this, "POST"], "post.post");
        $router->post("/{controle:[a-z\_]*}", [$this, "POST"], "post");
    }

    public function __construct(ContainerInterface $container) {

        $this->model = $container->get(Model::class);
        $this->FactoryTAG = $container->get(FactoryTAG::class);
        $this->renderer = $container->get(TwigRenderer::class);
    }

    public function MVC(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container, $params) {

        $page = $params["controle"];
        $this->model->setStatement($page);

        $intentshow = $this->model->show(Intent::MODE_SELECT_ALL_ALL, true);
        $intentform = $this->model->form(Intent::MODE_FORM);

        $table = $this->FactoryTAG->tableHTML($intentshow); //twig
        $form = $this->FactoryTAG->FormHTML($intentform);  //twig

        $query = $request->getQueryParams();
        $this->message($query);

        $data = $this->renderer->render("@achat/facture", ["form" => $form, "table" => $table]);


        $response->getBody()->write($data);
        return $response;
    }

    public function POST(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container, $params) {
        $insert = $request->getParsedBody();

        $page = $params["controle"];
        $this->model->setStatement($page);

        $msg = $this->model->setData($insert, Intent::MODE_INSERT);
        $msghtml = $this->FactoryTAG->message($msg);  //twig
        $data = $this->renderer->render("@achat/message_ajouter", ["message" => $msghtml]);
        $response->getBody()->write($data);
        return $response;
    }

    public function message($query) {
        if (isset($query["supprimer"])) {

        $conditon=['id' => $query['id']];
        
        $this->model->delete($conditon);
        
        } elseif (isset($query["modifier"])) {
            die("mod");
        } else {
            
        }
    }

}
