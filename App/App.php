<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of App
 *
 * @author wassime
 */

namespace App;

use App\Middleware\NotFound;
use Kernel\AWA_Interface\InterfaceRenderer;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\Kernel;
use Psr\Http\Message\ServerRequestInterface;
use function array_merge;
use function class_exists;
use function is_array;

class App extends Kernel {

    function run(ServerRequestInterface $request) {
        $this->router = $this->container->get(RouterInterface::class);
        $renderer = $this->container->get(InterfaceRenderer::class);
        $pathModules = $this->container->get("pathModules");
        $datamenu = [];

        foreach ($this->modules as $module) {

            if (class_exists($module)) {

                $m = new $module($this->container);
                $renderer->addGlobal("router", $this->router);
                $m->addRoute($this->router);
                $m->addPathRenderer($renderer, $pathModules);
                if (is_array($m->dataMenu())) {
                    $datamenu = array_merge($datamenu, $m->dataMenu());
                }
            }
            $renderer->addGlobal("_menu", $datamenu);
        }

        $route = $this->router->match($request);
        $this->addMiddleware(new NotFound($this->container));
        $this->addMiddleware($route->getMiddleware());

        $response = $this->despatcher->handle($request);
        return $response;
    }

}
