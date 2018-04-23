<?php

namespace Kernel;

use Kernel\Container\Factory_Container;
use Kernel\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Kernel
{

    private $container;
    private $modules;
    function __construct($config)
    {
        $this->container = Factory_Container::getContainer($config);
    }

    public function addModule(string $module)
    {
        $this->modules[] = $module;
    }

    public function run(ServerRequestInterface $request, ResponseInterface $respons)
    {


        $this->router = $this->container->get(Router::class);
        $renderer = $this->container->get(Renderer\TwigRenderer::class);
        $pathModules=$this->container->get("pathModules");

        foreach ($this->modules as $module) {
            if (class_exists($module)) {
                $m = new $module($this->container);
               
                $m->addRoute($this->router);
               
                $m->addPathRenderer($renderer, $pathModules);
            }
        }

        $route = $this->router->match($request);
        $call = $route->getCallable();
        
        $res = call_user_func_array($call, [$request, $respons]);

        if (is_string($res)) {
            $r = new \GuzzleHttp\Psr7\Response(404);
            $r->getBody()->write($res);
            $res = $r;
        }

        return $res;
    }
}
