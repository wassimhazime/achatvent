<?php

namespace Kernel\Router;

use Kernel\AWA_Interface\RouteInterface;
use Kernel\AWA_Interface\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as FastRouteRoute;

class Router implements RouterInterface
{

    private $router;

    function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    public function addRoute(string $url, MiddlewareInterface $middleware, $methods, string $name)
    {
        $route = new FastRouteRoute($url, $middleware, $methods, $name);
        $this->router->addRoute($route);
    }

    public function addRoute_get(string $url, MiddlewareInterface $middleware, string $name)
    {
        $this->addRoute($url, $middleware, ['GET'], $name);
    }

    public function addRoute_post(string $url, MiddlewareInterface $middleware, string $name)
    {
        $this->addRoute($url, $middleware, ['POST'], $name);
    }

    public function addRoute_put(string $url, MiddlewareInterface $middleware, string $name)
    {
        $this->addRoute($url, $middleware, ['PUT'], $name);
    }

    public function addRoute_patch(string $url, MiddlewareInterface $middleware, string $name)
    {
        $this->addRoute($url, $middleware, ['PATCH'], $name);
    }

    public function addRoute_delete(string $url, MiddlewareInterface $middleware, string $name)
    {
        $this->addRoute($url, $middleware, ['DELETE'], $name);
    }

    public function addRoute_any(string $url, MiddlewareInterface $middleware, string $name)
    {
        $this->addRoute($url, $middleware, null, $name);
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    public function generateUri($name, array $substitutions = [], array $options = []): string
    {
        return $this->router->generateUri($name, $substitutions, $options);
    }

    public function match(ServerRequestInterface $request): RouteInterface
    {
        $middleware = $this->router->match($request);
        $params = $middleware->getMatchedParams();
        $name = $middleware->getMatchedRouteName();
        return new Route($middleware, $name, $params, $middleware->isSuccess());
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $route = $this->match($request);
        $middleware = $route->getMiddleware();
        $response = $middleware->process($request, $handler);

        if (!$route->isSuccess()) {
            $response = $response->withStatus(404);
        }

        return $response;
    }
}
