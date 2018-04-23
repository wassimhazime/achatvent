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

namespace App\Modules\Comptable;

use App\Modules\Comptable\Controller\AjaxController;
use App\Modules\Comptable\Controller\TraitementController;
use App\Modules\Comptable\Controller\GetController;
use App\Modules\Comptable\Controller\PostController;
use App\Modules\Comptable\Controller\StatistiqueController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use const D_S;

class ComptableModule {

    private $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function addPathRenderer($renderer, $pathModules) {
        $renderer->addPath($pathModules . "Comptable" . D_S . "views" . D_S . "show", "show");
        $renderer->addPath($pathModules . "Comptable" . D_S . "views" . D_S . "traitement", "traitement");
        $renderer->addPath($pathModules . "Comptable" . D_S . "views" . D_S . "statistique", "statistique");
    }

    public function addRoute($router) {


        $router->get("/{controle:[a-z\$]*}", [$this, "Statistique"], "home.get");
        $router->get("/{action:[a-z]+}-{controle:[a-z\$]+}", [$this, "GET"], "actionGET");
        $router->get("/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", [$this, "traitement"], "traitement");

        $router->post("/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", [$this, "POST"], "posttraitement");
        $router->post("/{controle:[a-z]+}", [$this, "POST"], "post.post");

        $router->get("/st/{controle:[a-z\$]*}", [$this, "Statistique"], "st.get");

        //ajax
        $router->get("/ajax/{controle:[a-z\$]+}", [$this, "ajax"], "ajax.get");
        $router->post("/ajax/{controle:[a-z\$]+}", [$this, "ajax"], "ajax.post");
    }

    public function GET(ServerRequestInterface $request, ResponseInterface $response) {

        $controller = new GetController($request, $response, $this->container, "controle");

        return $controller->exec();
    }

    public function traitement(ServerRequestInterface $request, ResponseInterface $response) {

        $controller = new TraitementController($request, $response, $this->container, "controle");

        return $controller->exec();
    }

    public function POST(ServerRequestInterface $request, ResponseInterface $response) {

        $controller = new PostController($request, $response, $this->container, "controle");

        return $controller->exec();
    }

    public function ajax(ServerRequestInterface $request, ResponseInterface $response) {
        $controller = new AjaxController($request, $response, $this->container, "controle");
        return $controller->exec();
    }

    public function Statistique(ServerRequestInterface $request, ResponseInterface $response) {

        $controller = new StatistiqueController($request, $response, $this->container, "controle");

        return $controller->exec();
    }

}
