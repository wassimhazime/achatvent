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

use App\Modules\Comptable\Controller\StatistiqueController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use const D_S;

class StatistiqueModule
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function addPathRenderer($renderer, $pathModules)
    {

        $renderer->addPath($pathModules . "Statistique" . D_S . "views" . D_S . "statistique", "statistique");
    }

    public function addRoute($router)
    {

        $router->get("/{controle:[a-z\$]*}", [$this, "Statistique"], "home.get");

        $router->get("/st/{controle:[a-z\$]*}", [$this, "Statistique"], "st.get");
    }

    public function Statistique(ServerRequestInterface $request, ResponseInterface $response)
    {

        $controller = new StatistiqueController($request, $response, $this->container, "controle");

        return $controller->exec();
    }
}
