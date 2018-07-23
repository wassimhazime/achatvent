<?php

namespace Kernel;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class Kernel {

    protected $container;
    protected $modules;
    protected $despatcher;

    function __construct(ContainerInterface $container) {

        $this->container = $container;
        $this->despatcher = $this->container->get(RequestHandlerInterface::class);
    }

    public function addModule(string $module) {
        $this->modules[] = $module;
    }

    public function run(ServerRequestInterface $request) {
        $response = $this->despatcher->handle($request);
        return $response;
    }

    function addMiddleware(MiddlewareInterface $Middleware) {
        $this->despatcher->pipe($Middleware);
    }

    function addEvent($param1, $m) {
        
    }

}
