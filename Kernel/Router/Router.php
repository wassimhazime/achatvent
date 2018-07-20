<?php

namespace Kernel\Router;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Psr\Http\Server\MiddlewareInterface;

class Router implements \Kernel\AWA_Interface\RouterInterface {

    private $router;

    function __construct() {
        $this->router = new FastRouteRouter();
    }

    public function get(string $url,MiddlewareInterface $middleware, string $name) {
        $route = new \Zend\Expressive\Router\Route($url, $middleware, ['GET'], $name);
        $this->router->addRoute($route);
    }

    public function post(string $url, MiddlewareInterface $middleware, string $name) {
        $route = new \Zend\Expressive\Router\Route($url, $middleware, ['POST'], $name);
        $this->router->addRoute($route);
    }

    public function generateUri($name, array $substitutions = [], array $options = []) {
        return $this->router->generateUri($name, $substitutions, $options);
    }

    public function match(ServerRequestInterface $request): Route {
        $routeResulte = $this->router->match($request);


        if ($routeResulte->isSuccess()) {
            $middleware = $routeResulte;
            $params = $routeResulte->getMatchedParams();
            $name = $routeResulte->getMatchedRouteName();
        } else {
            ////
            $middleware = null;
            $params = [];
            $name = "notFound";
        }
        return new Route($middleware, $name, $params);
    }

}
