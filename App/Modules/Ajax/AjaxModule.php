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

namespace App\Modules\Ajax;

use App\Modules\Ajax\Controller\AjaxController;
use Kernel\AWA_Interface\InterfaceRenderer;
use Kernel\Router\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AjaxModule {

    private $container;
    private $router;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->router = $this->container->get(Router::class);
    }

    public function addPathRenderer(InterfaceRenderer $renderer, $pathModules) {
      
    }

    public function dataMenu() {

        return [];
    }

    public function addRoute($router) {
    

        $router->get("/ajax/{controle:[a-z\$]+}", [$this, "ajax"], "ajax.get");
        $router->post("/ajax/{controle:[a-z\$]+}", [$this, "ajax"], "ajax.post");
    }

 

    public function ajax(ServerRequestInterface $request, ResponseInterface $response) {
        $controller = new AjaxController($request, $response, $this->container, "controle");
        return $controller->exec();
    }



   

}
