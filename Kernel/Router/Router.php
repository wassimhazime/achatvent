<?php
namespace Kernel\Router;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\FastRouteRouter;

class Router implements \Kernel\AWA_Interface\RouterInterface
{
    
    private $router;
    function __construct()
    {
        $this->router=new FastRouteRouter();
    }

    public function get(string $url, callable $callable, string $name)
    {
        $route = new \Zend\Expressive\Router\Route($url, $callable, ['GET'], $name);
        $this->router->addRoute($route);
    }
    public function post(string $url, callable $callable, string $name)
    {
        $route = new \Zend\Expressive\Router\Route($url, $callable, ['POST'], $name);
        $this->router->addRoute($route);
    }
    public function generateUri($name, array $substitutions = [], array $options = [])
    {
        return   $this->router->generateUri($name, $substitutions, $options);
    }
    
    
    public function match(ServerRequestInterface $request) :Route
    {
        $routeResulte=  $this->router->match($request);
      
        
        if ($routeResulte->isSuccess()) {
            $callable=  $routeResulte->getMatchedMiddleware();
            $params=  $routeResulte->getMatchedParams();
            $name=  $routeResulte->getMatchedRouteName();
        } else {
            $callable= function () {
                return "notFound";
            };
            $params=  [];
            $name=  "notFound";
        }
        return new Route($callable, $name, $params);
    }
}
