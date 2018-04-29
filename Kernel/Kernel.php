<?php

namespace Kernel;

use Kernel\Container\Factory_Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Kernel {

    protected $container;
    protected $modules;

    function __construct($config) {
        $this->container = Factory_Container::getContainer($config);
    }

    public function addModule(string $module) {
        $this->modules[] = $module;
    }

    abstract function run(ServerRequestInterface $request, ResponseInterface $respons);
}
