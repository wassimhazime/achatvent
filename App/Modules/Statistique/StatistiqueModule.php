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

use App\AbstractModules\AbstractModule;
use App\Modules\Statistique\Controller\globalController;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use const D_S;

class StatistiqueModule extends AbstractModule {

    public function addPathRenderer(RendererInterface $renderer, string $pathModules) {
        $pathModule = $pathModules . "Statistique" . D_S . "views" . D_S;
        $renderer->addPath($pathModule . "statistique", "statistique");
    }

    public function addRoute(RouterInterface $router,array $middlewares) {

        $router->addRoute_any("/{controle:[a-z\$]*}", new globalController($this->container), "home.get");

        $router->addRoute_any("/st/{controle:[a-z\$]*}", new Controller\AjaxController($this->container), "st.get");
    }

    public function getMenu(): array {
        $nav1 = $this->generateUriMenu("home.get", ["clients", 'raison$sociale', 'contacts', 'mode$paiement']);


        $menu = [
            ["nav_title" => "statistique", "nav_icon" => ' fa fa-fw fa-bar-chart-o ', "nav" => $nav1]
        ];

        return $menu;
    }

}
