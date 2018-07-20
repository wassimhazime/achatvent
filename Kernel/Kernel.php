<?php

namespace Kernel;

use Kernel\Container\Factory_Container;
use Kernel\Middleware\Despatcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Kernel {

    protected $container;
    protected $modules;
    protected $despatcher;

    function __construct($config) {

        $this->container = Factory_Container::getContainer($config);
        $this->despatcher = Despatcher::getDespatch();
    }

    public function addModule(string $module) {
        $this->modules[] = $module;
    }

    abstract function run(ServerRequestInterface $request);

    function addMiddleware($Middleware) {
        $this->despatcher->pipe($Middleware);
    }

    function addEvent($param1, $m) {
        
    }

}
