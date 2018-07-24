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
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use Psr\Container\ContainerInterface;
use const D_S;
use function str_replace;

class StatistiqueModule {

    private $container;
    private $router;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->router = $this->container->get(RouterInterface::class);
    }

    public function addPathRenderer(RendererInterface $renderer, $pathModules) {

        $renderer->addPath($pathModules . "Statistique" . D_S . "views" . D_S . "statistique", "statistique");
    }

    public function addRoute(RouterInterface $router) {

        $router->addRoute_any("/{controle:[a-z\$]*}",
                new globalController($this->container, "controle"),
                "home.get");

        $router->addRoute_any("/st/{controle:[a-z\$]*}",
                new Controller\AjaxController($this->container, "controle"), 
                "st.get");
    }

    public function dataMenu() {
        $nav1 = $this->generateUriMenu("home.get", ["clients", 'raison$sociale', 'contacts', 'mode$paiement']);


        $menu = [
            ["nav_title" => "statistique", "nav_icon" => ' fa fa-fw fa-bar-chart-o ', "nav" => $nav1]
        ];

        return $menu;
    }

    private function generateUriMenu(string $route, array $info): array {

        $infogenerate = [];
        foreach ($info as $controle) {


            $label = str_replace("$", "  ", $controle);
            $url = $this->router->generateUri($route, ["controle" => $controle]);

            $infogenerate[$label] = $url;
        }

        return $infogenerate;
    }

}
