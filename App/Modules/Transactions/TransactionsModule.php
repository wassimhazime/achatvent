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

use App\Modules\Transactions\Controller\TraitementSendController;
use App\Modules\Transactions\Controller\TraitementShowController;
use App\Modules\Transactions\Controller\VoirController;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use Psr\Container\ContainerInterface;
use const D_S;
use function str_replace;

class TransactionsModule {

    private $container;
    private $router;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->router = $this->container->get(RouterInterface::class);
    }

    public function addPathRenderer(RendererInterface $renderer, $pathModules) {
        $renderer->addPath($pathModules . "Transactions" . D_S . "views" . D_S . "show", "TransactionsShow");
        $renderer->addPath($pathModules . "Transactions" . D_S . "views" . D_S . "traitement", "TransactionsTraitement");
    }

    public function addRoute(RouterInterface $router) {

        $router->addRoute_get("/admin/{action:[a-z]+}-{controle:[a-z\$]+}", new VoirController($this->container, "controle"), "TransactionVoirGet");

        $router->addRoute_get("/admin/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9\,]+}", new TraitementShowController($this->container, "controle"), "TransactionTraitementShow");

        $router->addRoute_post("/admin/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", new TraitementSendController($this->container, "controle"), "TransactionTraitementSend");

        $router->addRoute_get("/admin/ajax_{controle:[a-z\$]+}", new Controller\AjaxController($this->container, "controle"), "TransactionAjax");
        $router->addRoute_get("/admin/files/{controle:[a-z0-9\_\$\-]+}", new Controller\FileController($this->container, "controle"), "TransactionFiles");
    }

    /// menu
    public function dataMenu() {
        $nav1 = $this->generateUriMenu("TransactionVoirGet", ["achats", 'ventes']);


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
