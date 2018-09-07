<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Middleware;

use Kernel\AWA_Interface\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of Authentification
 *
 * @author wassime
 */
class Authentification implements MiddlewareInterface {

    private $container;
    private $router;
    private $Response;

    function __construct($container) {
        $this->container = $container;
        $this->router = $container->get(RouterInterface::class);
        $this->Response = $container->get(ResponseInterface::class);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {

        $url = $request->getUri()->getPath();
        
        $url_login = $this->router->generateUri("login");
        
        if ($url == $url_login) {
            return $handler->handle($request);
        }
        if (isset($_SESSION["aut"]) && !empty($_SESSION["aut"])) {
            return $handler->handle($request);
        } else {
            return $this->Response->withHeader("Location", $url_login)->withStatus(403);
        }
    }

}
