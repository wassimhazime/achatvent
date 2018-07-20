<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Middleware;

use Kernel\AWA_Interface\InterfaceRenderer;
use Kernel\AWA_Interface\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of Midd_pse15
 *
 * @author wassime
 */
class NotFound implements MiddlewareInterface {

    private $container;
    private $router;

    function __construct($container) {
        $this->container = $container;
        $this->router = $this->container->get(RouterInterface::class);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {

        $Response = $handler->handle($request);
        $route = $this->router->match($request);
        $code = $Response->getStatusCode();

        if ($code === 404 || !$route->isSuccess()) {

            // is json page not found
            $isjson = implode(" ", $Response->getHeader("Content-Type"));
            preg_match('/(.+)\/json(.+)/i', $isjson, $matches);
            if (!empty($matches)) {
                $Response->getBody()->write("{}");
                return $Response;
            }
            // is html page not found
            $render = $this->container->get(InterfaceRenderer::class)
                    ->render("404", ["_page" => "404"]);

            $Response->getBody()->write($render);
        }

        return $Response;
    }

}
