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

namespace App\Modules\Transactions;

use App\Modules\Transactions\Controller\TraitementController;
use App\Modules\Transactions\Controller\GetController;
use App\Modules\Transactions\Controller\PostController;
use App\Modules\Transactions\Controller\Child_add;
use Kernel\AWA_Interface\InterfaceRenderer;
use Kernel\Router\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TransactionsModule {

    private $container;
    private $router;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->router = $this->container->get(Router::class);
    }

    public function addPathRenderer(InterfaceRenderer $renderer, $pathModules) {
        $renderer->addPath($pathModules . "Transactions" . D_S . "views" . D_S . "show", "T_show");
        $renderer->addPath($pathModules . "Transactions" . D_S . "views" . D_S . "traitement", "T_traitement");
    }

    public function addRoute($router) {

        $router->get("/admin/{action:[a-z]+}-{controle:[a-z\$]+}", [$this, "GET"], "T_actionGET");
        
        $router->get("/admin/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", [$this, "traitement"], "T_traitement");

        $router->post("/admin/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", [$this, "POST"], "T_posttraitement");

        $router->post("/admin/{controle:[a-z]+}", [$this, "POST"], "T_post.post");
        
        $router->post("/admin/{controle:[a-z]+}_{action:[a-z]+}", [$this, "child_add"], "T_child_add.post");
    }

    //// controller
    public function GET(ServerRequestInterface $request, ResponseInterface $response) {

        $controller = new GetController($request, $response, $this->container, "controle");

        return $controller->exec();
    }

    public function traitement(ServerRequestInterface $request, ResponseInterface $response) {

        $controller = new TraitementController($request, $response, $this->container, "controle");

        return $controller->exec();
    }

    public function child_add(ServerRequestInterface $request, ResponseInterface $response) {

        $controller = new Child_add($request, $response, $this->container, "controle");

        return $controller->exec();
    }

    public function POST(ServerRequestInterface $request, ResponseInterface $response) {

        $controller = new PostController($request, $response, $this->container, "controle");

        return $controller->exec();
    }

    
    
    
    
    
    
    /// menu
    public function dataMenu() {
        $nav1 = $this->generateUriMenu("T_actionGET", ["achats", 'recette']);


        $menu = [
            ["nav_title" => "Transactions", "nav_icon" => ' fa fa-fw fa-briefcase ', "nav" => $nav1]
        ];

        return $menu;
    }

    private function generateUriMenu(string $route, array $info): array {

        $infogenerate = [];
        foreach ($info as $controle) {


            $label = str_replace("$", "  ", $controle);
            $url = $this->router->generateUri($route, ["controle" => $controle, "action" => "voir"]);

            $infogenerate[$label] = $url;
        }

        return $infogenerate;
    }

}
