<?php

namespace App\Modules\Comptable;

use App\Modules\Comptable\Controller\TraitementSendController;
use App\Modules\Comptable\Controller\TraitementShowController;
use App\Modules\Comptable\Controller\VoirController;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use Psr\Container\ContainerInterface;
use const D_S;
use function str_replace;

class ComptableModule {

    private $container;
    private $router;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->router = $this->container->get(RouterInterface::class);
    }

    public function addPathRenderer(RendererInterface $renderer, $pathModules) {
        $renderer->addPath($pathModules . "Comptable" . D_S . "views" . D_S . "show", "ComptableShow");
        $renderer->addPath($pathModules . "Comptable" . D_S . "views" . D_S . "traitement", "ComptableTraitement");
    }

    public function addRoute(RouterInterface $router) {

        $router->addRoute_get("/voir-{controle:[a-z\$]+}", new VoirController($this->container, "controle"), "ComptableVoirGet");


        $router->addRoute_get("/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9\,]+}", new TraitementShowController($this->container, "controle"), "ComptableTraitementShow");


        $router->addRoute_post("/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", new TraitementSendController($this->container, "controle"), "ComptableTraitementSend");


        $router->addRoute_get("/ajaxcomptable/{controle:[a-z\$]+}", new Controller\AjaxController($this->container, "controle"), "ComptableAjax");


        $router->addRoute_get("/files/{controle:[a-z0-9\_\$\-]+}", new Controller\FileController($this->container, "controle"), "ComptableFiles");
    }

    // //////////////////////
    public function dataMenu() {
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

    private function generateUriMenu(string $route, array $info): array {
        $infogenerate = [];
        foreach ($info as $controle) {

            $label = str_replace("$", "  ", $controle);
            $url = $this->router->generateUri($route, [
                "controle" => $controle
            ]);

            $infogenerate[$label] = $url;
        }

        return $infogenerate;
    }

}
