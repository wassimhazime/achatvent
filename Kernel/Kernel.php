<?php

namespace Kernel;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class Kernel {

    protected $container;
    protected $modules = [];
    protected $despatcher;

    function __construct(ContainerInterface $container) {

        $this->container = $container;
        $this->despatcher = $this->container->get(RequestHandlerInterface::class);
    }

    abstract function run_modules();

    public function addModule(string $module, array $middlewares = []) {
        if (class_exists($module)) {
            $this->modules[] = ["module" => $module,
                "middlewares" => $middlewares];
        }
    }

    public function run(ServerRequestInterface $request) {
        $this->run_modules();
        $response = $this->despatcher->handle($request);
        return $response;
    }

    function addMiddleware($Middlewares) {
        if (is_a($Middlewares, MiddlewareInterface::class)) {
            $this->despatcher->pipe($Middlewares);
        } elseif (is_array($Middlewares)) {
            foreach ($Middlewares as $Middleware) {
                $this->addMiddleware($Middleware);
            }
        }
    }

    function addEvent($param1, $m) {
        
    }

}
