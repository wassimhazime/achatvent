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

use App\AbstractModules\AbstractModule;
use App\Modules\Transactions\Controller\TraitementSendController;
use App\Modules\Transactions\Controller\TraitementShowController;
use App\Modules\Transactions\Controller\VoirController;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use const D_S;

class TransactionsModule extends AbstractModule {

    public function addPathRenderer(RendererInterface $renderer, string $pathModules) {
        $pathModule = $pathModules . "Transactions" . D_S . "views" . D_S;
        $renderer->addPath($pathModule . "show", "TransactionsShow");
        $renderer->addPath($pathModule . "traitement", "TransactionsTraitement");
    }

    public function addRoute(RouterInterface $router, array $middlewares) {
        $v = new VoirController($this->container);
        $v->setMiddlewares($middlewares);
        $router->addRoute_get("/admin/{action:[a-z]+}-{controle:[a-z\$]+}", $v, "TransactionVoirGet");

        $router->addRoute_get("/admin/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9\,]+}", new TraitementShowController($this->container), "TransactionTraitementShow");

        $router->addRoute_post("/admin/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", new TraitementSendController($this->container), "TransactionTraitementSend");

        $router->addRoute_get("/admin/ajax_{controle:[a-z\$]+}", new Controller\AjaxController($this->container), "TransactionAjax");
        $router->addRoute_get("/admin/files/{controle:[a-z0-9\_\$\-]+}", new Controller\FileController($this->container), "TransactionFiles");
    }

    public function getMenu(): array {
        $nav1 = $this->generateUriMenu("TransactionVoirGet", ["achats", 'ventes']);


        $menu = [
            ["nav_title" => "Transactions", "nav_icon" => ' fa fa-fw fa-briefcase ', "nav" => $nav1]
        ];

        return $menu;
    }

}
