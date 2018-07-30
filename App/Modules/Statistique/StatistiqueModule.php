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

class StatistiqueModule extends AbstractModule
{

    const Controllers = [
        "clients",
        'raison$sociale',
        'contacts',
        'mode$paiement'
    ];

    public function addPathRenderer(RendererInterface $renderer)
    {
        $pathModule = __DIR__ . D_S . "views" . D_S;
        $renderer->addPath($pathModule . "statistique", "statistique");
    }

    public function addRoute(RouterInterface $router, array $middlewares)
    {

        $router->addRoute_any("/{controle:[a-z\$]*}", new globalController($this->container, self::Controllers), "home.get");

        $router->addRoute_any("/st/{controle:[a-z\$]*}", new Controller\AjaxController($this->container, self::Controllers), "st.get");
    }

    public function getMenu(): array
    {


        $menu = [
            [
                "nav_title" => "statistique",
                "nav_icon" => ' fa fa-fw fa-bar-chart-o ',
                "nav" => $this->generateUriMenu("home.get", self::Controllers)
            ]
        ];

        return $menu;
    }
}
