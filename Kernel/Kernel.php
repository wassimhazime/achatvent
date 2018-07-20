<?php

namespace Kernel;

use Kernel\Container\Factory_Container;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

abstract class Kernel {

    protected $container;
    protected $modules;
    protected $despatcher;

    function __construct($config) {

        $this->container = Factory_Container::getContainer($config);
        $this->despatcher = $this->container->get(RequestHandlerInterface::class);
    }

    public function addModule(string $module) {
        $this->modules[] = $module;
    }

    abstract function run(ServerRequestInterface $request);

    function addMiddleware(MiddlewareInterface $Middleware) {
        $this->despatcher->pipe($Middleware);
    }

    function addEvent($param1, $m) {
        
    }

}
