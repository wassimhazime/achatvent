<?php

namespace Kernel;

use Kernel\AWA_Interface\ModuleInterface;
use Kernel\Container\Factory_Container;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use const DS;
use const ROOT;
use function class_exists;
use function dirname;
use function is_a;
use function is_array;
use function str_replace;

abstract class Kernel {

    protected $container;
    protected $despatcher;
    protected $modules = [];
    protected $pathModules = [];

    function __construct(string $pathconfig) {

        $container = Factory_Container::getContainer($pathconfig);
        $this->container = $container;
        $this->despatcher = $container->get(RequestHandlerInterface::class);
    }

    function getContainer(): ContainerInterface {
        return $this->container;
    }

    public function addModule(string $name_module, array $middlewares = []) {
        if (class_exists($name_module)) {
            $object_module = new $name_module($this->container);

            if (is_a($object_module, ModuleInterface::class)) {

                $object_module->addMiddlewares($middlewares);
                $this->modules[] = $object_module;
                // phinix config
                $this->pathModules[] = dirname(ROOT . str_replace("\\", DS, $name_module));
            }
        }
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

    public function run(ServerRequestInterface $request) {

        $this->run_modules();
        $response = $this->despatcher->handle($request);
        return $response;
    }

    abstract function run_modules();
}
