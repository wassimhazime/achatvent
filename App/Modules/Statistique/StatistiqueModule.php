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

namespace App\Modules\Statistique;

use App\Modules\Statistique\Controller\globalController;
use Kernel\AWA_Interface\InterfaceRenderer;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\Router\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use const D_S;

class StatistiqueModule {

    private $container;
    private $router;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->router = $this->container->get(Router::class);
    }

    public function addPathRenderer(InterfaceRenderer $renderer, $pathModules) {

        $renderer->addPath($pathModules . "Statistique" . D_S . "views" . D_S . "statistique", "statistique");
    }

    public function dataMenu() {
        return  [
            "_login" => [['devis'=>"y"], ['factures$ventes'=>"kkkk"]],
            "_rapports" => [],
            "_recherche" => [],
            "_statistique" => [],
            "_transactions" => [],
            "_tva" => []
        ];
    }

    public function addRoute(RouterInterface $router) {

        $router->get("/{controle:[a-z\$]*}", [$this, "Statistique"], "home.get");

        $router->get("/st/{controle:[a-z\$]*}", [$this, "Statistique"], "st.get");
    }

    public function Statistique(ServerRequestInterface $request, ResponseInterface $response) {

        $controller = new globalController($request, $response, $this->container, "controle");

        return $controller->exec();
    }

}
