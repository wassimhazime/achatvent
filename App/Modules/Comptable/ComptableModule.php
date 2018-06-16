<?php

namespace App\Modules\Comptable;

use App\Modules\Comptable\Controller\TraitementController;
use App\Modules\Comptable\Controller\VoirController;
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

    public function addRoute($router) {
        
        $router->get("/voir-{controle:[a-z\$]+}", [$this, "Voir" ], "VoirGet");
        
        $router->get("/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9\,]+}", [ $this,  "traitement" ], "traitement");

        
        
        $router->post("/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", [
            $this,
            "POST"
                ], "posttraitement");


        $router->get("/ajax/{controle:[a-z\$]+}", [
            $this,
            "ajax"
                ], "ajax.get");

    }

    // // controller


    public function ajax(ServerRequestInterface $request, ResponseInterface $response) {
        $controller = new Controller\AjaxController($request, $response, $this->container, "controle");
        return $controller->exec();
    }

    public function Voir(ServerRequestInterface $request, ResponseInterface $response) {
        $controller = new VoirController($request, $response, $this->container, "controle");

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

    // //////////////////////
    public function dataMenu() {
        $nav1 = $this->generateUriMenu("VoirGet", [
            "clients",
            'raison$sociale',
            'contacts',
            'mode$paiement'
        ]);
        $nav2 = $this->generateUriMenu("VoirGet", [
            'commandes',
            'bons$achats',
            'factures$achats',
            'avoirs$achats'
        ]);
        $nav3 = $this->generateUriMenu("VoirGet", [
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
