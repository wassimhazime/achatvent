<?php

namespace App\Modules\Comptable;

use App\AbstractModules\AbstractModule;
use App\Modules\Comptable\Controller\TraitementSendController;
use App\Modules\Comptable\Controller\TraitementShowController;
use App\Modules\Comptable\Controller\VoirController;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use const D_S;

class ComptableModule extends AbstractModule {

    public function addPathRenderer(RendererInterface $renderer, string $pathModules) {
        $pathModule = $pathModules . "Comptable" . D_S . "views" . D_S;

        $renderer->addPath($pathModule . "show", "ComptableShow");
        $renderer->addPath($pathModule . "traitement", "ComptableTraitement");
    }

    public function addRoute(RouterInterface $router,array $middlewares) {

        $router->addRoute_get("/{action:[a-z]+}-{controle:[a-z\$]+}", new VoirController($this->container), "ComptableVoirGet");


        $router->addRoute_get("/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9\,]+}", new TraitementShowController($this->container), "ComptableTraitementShow");


        $router->addRoute_post("/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", new TraitementSendController($this->container), "ComptableTraitementSend");


        $router->addRoute_get("/ajaxcomptable/{controle:[a-z\$]+}", new Controller\AjaxController($this->container), "ComptableAjax");


        $router->addRoute_get("/files/{controle:[a-z0-9\_\$\-]+}", new Controller\FileController($this->container), "ComptableFiles");
    }

    // //////////////////////
    public function getMenu(): array {
        $nav1 = $this->generateUriMenu("ComptableVoirGet", [
            "clients",
            'raison$sociale',
            'contacts',
            'mode$paiement'
        ]);
        $nav2 = $this->generateUriMenu("ComptableVoirGet", [
            'commandes',
            'bons$achats',
            'factures$achats',
            'avoirs$achats'
        ]);
        $nav3 = $this->generateUriMenu("ComptableVoirGet", [
            'devis',
            'factures$ventes'
        ]);

        $menu = [
            [
                "nav_title" => "CRM",
                "nav_icon" => ' fa fa-fw fa-stack-overflow ',
                "nav" => $nav1
            ],
            [
                "nav_title" => "achats",
                "nav_icon" => ' fa fa-fw fa-shopping-cart ',
                "nav" => $nav2
            ],
            [
                "nav_title" => "ventes",
                "nav_icon" => ' fa fa-fw fa-usd   ',
                "nav" => $nav3
            ]
        ];

        return $menu;
        // // "group"=> [[lable,url],....]
    }

}
