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
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Kernel\Router\Router;
use const D_S;

class ComptableModule {

    private $container;
    private $router;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->router = $this->container->get(Router::class);
    }

    public function addPathRenderer(\Kernel\AWA_Interface\InterfaceRenderer $renderer, $pathModules) {
        $renderer->addPath($pathModules . "Comptable" . D_S . "views" . D_S . "show", "show");
        $renderer->addPath($pathModules . "Comptable" . D_S . "views" . D_S . "traitement", "traitement");
    }

    public function dataMenu() {


        $nav1 = $this->generateUriMenu("actionGET", ["clients", 'raison$sociale', 'contacts', 'mode$paiement']);
        $nav2 = $this->generateUriMenu("actionGET", ['commandes', 'bons$achats', 'avoirs$achats', 'factures$achats', "achats"]);
        $nav3 = $this->generateUriMenu("actionGET", ['devis', 'factures$ventes', 'ventes']);

        $menu = [
            ["nav_title" => "CRM", "nav_icon" => ' fa fa-fw fa-stack-overflow ', "nav" => $nav1],
            ["nav_title" => "achats", "nav_icon" => ' fa fa-fw fa-shopping-cart ', "nav" => $nav2],
            ["nav_title" => "ventes", "nav_icon" => ' fa fa-fw fa-usd   ', "nav" => $nav3]
        ];
       
        return $menu;
//// "group"=> [[lable,url],....]
    }

    public function addRoute($router) {
        $router->get("/{action:[a-z]+}-{controle:[a-z\$]+}", [$this, "GET"], "actionGET");
        $router->get("/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", [$this, "traitement"], "traitement");

        $router->post("/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", [$this, "POST"], "posttraitement");
        $router->post("/{controle:[a-z]+}", [$this, "POST"], "post.post");
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

    ////////////////////////

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
