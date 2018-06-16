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

use GuzzleHttp\Psr7\Response;
use Kernel\Kernel;
use Kernel\Renderer\TwigRenderer;
use Kernel\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App extends Kernel {

    function run(ServerRequestInterface $request, ResponseInterface $respons) {



        $this->router = $this->container->get(Router::class);
        
        $renderer = $this->container->get(TwigRenderer::class);
        $pathModules = $this->container->get("pathModules");
        $datamenu = [];

        foreach ($this->modules as $module) {

            if (class_exists($module)) {

                $m = new $module($this->container);
                $renderer->addGlobal("router", $this->router);
                $m->addRoute($this->router);
                $m->addPathRenderer($renderer, $pathModules);
                if(is_array($m->dataMenu())){
                 $datamenu = array_merge($datamenu, $m->dataMenu());   
                }

                
            }
            $renderer->addGlobal("_menu", $datamenu);
        }

        $route = $this->router->match($request);
        $call = $route->getCallable();

        $res = call_user_func_array($call, [$request, $respons]);

        if (is_string($res)) {
            $r = new Response(404);
            $r->getBody()->write($res);
            $res = $r;
        }

        return $res;
    }

}
