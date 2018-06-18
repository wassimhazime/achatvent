<?php

namespace App\Modules\Comptable;

use App\Modules\Comptable\Controller\TraitementShowController;
use App\Modules\Comptable\Controller\VoirController;
use App\Modules\Comptable\Controller\TraitementSendController;
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
        $renderer->addPath($pathModules . "Comptable" . D_S . "views" . D_S . "show", "ComptableShow");
        $renderer->addPath($pathModules . "Comptable" . D_S . "views" . D_S . "traitement", "ComptableTraitement");
    }

    public function addRoute($router) {

        $router->get("/voir-{controle:[a-z\$]+}", [$this, "Voir"], "ComptableVoirGet");
        $router->get("/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9\,]+}", [$this, "traitementShow"], "ComptableTraitementShow");
        $router->post("/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", [$this, "traitementSend"], "ComptableTraitementSend");
        $router->get("/ajaxcomptable/{controle:[a-z\$]+}", [$this, "ajax"], "ComptableAjax");
        $router->get("/files/{controle:[a-z0-9\_\$\-]+}", [$this, "files"], "ComptableFiles");
    }

    // // controller


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

    public function traitementSend(ServerRequestInterface $request, ResponseInterface $response) {
        $controller = new TraitementSendController($request, $response, $this->container, "controle");

        return $controller->exec();
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
