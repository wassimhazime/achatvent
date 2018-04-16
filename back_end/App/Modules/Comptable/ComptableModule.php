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

use App\Modules\Comptable\Controller\GetController;
use App\Modules\Comptable\Controller\PostController;
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
        $renderer->addPath($pathModules . "Comptable" . D_S . "views", "achat");
    }

    public function addRoute($router) {
        $router->get("/{controle:[a-z\_\-\$]+}", [$this, "GET"], "get");
        $router->get("/achat/{controle:[a-z\_\-\$]+}", [$this, "GET"], "achat.get");
        $router->post("/achat/{controle:[a-z\_\-\$]+}", [$this, "POST"], "post.post");
    }

    public function GET(ServerRequestInterface $request, ResponseInterface $response) {
        
        $controller = new GetController($this->container);
        
        return $controller->exec($request, $response);
    }

    public function POST(ServerRequestInterface $request, ResponseInterface $response) {
        
        $controller = new PostController($this->container);
        
        return $controller->exec($request, $response);
    }

}
