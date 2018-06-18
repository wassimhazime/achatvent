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

use App\Modules\Transactions\Controller\TraitementShowController;
use App\Modules\Transactions\Controller\VoirController;
use App\Modules\Transactions\Controller\TraitementSendController;
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
        $renderer->addPath($pathModules . "Transactions" . D_S . "views" . D_S . "show", "TransactionsShow");
        $renderer->addPath($pathModules . "Transactions" . D_S . "views" . D_S . "traitement", "TransactionsTraitement");
    }

    public function addRoute($router) {

        $router->get("/admin/{action:[a-z]+}-{controle:[a-z\$]+}", [$this, "Voir"], "TransactionVoirGet");

        $router->get("/admin/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9\,]+}", [$this, "traitementShow"], "TransactionTraitementShow");

        $router->post("/admin/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", [$this, "traitementSend"], "TransactionTraitementSend");

        $router->post("/admin/{controle:[a-z]+}", [$this, "traitementSend"], "T_post.post");
        $router->post("/admin/{controle:[a-z]+}_{action:[a-z]+}", [$this, "child_add"], "T_child_add.post");
        $router->get("/admin/ajax_{controle:[a-z\$]+}", [$this, "ajax"], "TransactionAjax");
        $router->get("/admin/files/{controle:[a-z0-9\_\$\-]+}", [$this, "files"], "TransactionFiles");
    }

    //// controller


    public function ajax(ServerRequestInterface $request, ResponseInterface $response) {
        $controller = new Controller\AjaxController($request, $response, $this->container, "controle");
        return $controller->exec();
    }

    public function files(ServerRequestInterface $request, ResponseInterface $response) {
        $controller = new Controller\FileController($request, $response, $this->container, "controle");
        return $controller->exec();
    }

    public function Voir(ServerRequestInterface $request, ResponseInterface $response) {

        $controller = new VoirController($request, $response, $this->container, "controle");

        return $controller->exec();
    }

    public function traitementShow(ServerRequestInterface $request, ResponseInterface $response) {

        $controller = new TraitementShowController($request, $response, $this->container, "controle");

        return $controller->exec();
    }

    public function child_add(ServerRequestInterface $request, ResponseInterface $response) {

        $controller = new Child_add($request, $response, $this->container, "controle");

        return $controller->exec();
    }

    public function traitementSend(ServerRequestInterface $request, ResponseInterface $response) {

        $controller = new TraitementSendController($request, $response, $this->container, "controle");

        return $controller->exec();
    }

    /// menu
    public function dataMenu() {
        $nav1 = $this->generateUriMenu("TransactionVoirGet", ["achats", 'recette']);


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
