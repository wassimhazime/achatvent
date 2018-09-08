<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Middleware;

use App\Authentification\AutorisationInterface;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\AWA_Interface\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function preg_match;

/**
 * Description of Authentification
 *
 * @author wassime
 */
class Authentification implements MiddlewareInterface, AutorisationInterface {

    private $container;
    private $router;
    private $Response;
    private $Session;

    function __construct(\Psr\Container\ContainerInterface $container) {
        $this->container = $container;
        $this->router = $container->get(RouterInterface::class);
        $this->Response = $container->get(ResponseInterface::class);
        $this->Session = $container->get(SessionInterface::class);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        $route = $this->getRouter()->match($request);
        // not is in modules
        if (!$route->isSuccess()) {
            return $handler->handle($request);
        }
        //  is in login page
        $url = $request->getUri()->getPath();
        $url_login = $this->getRouter()->generateUri("login");
        if ($url == $url_login) {
            return $handler->handle($request);
        }



     







        if ($this->getSession()->has(self::Name_Key_Session)) {
        $nameModule = $this->parseNameModule($request);
        $nameControler = $this->parseNameControler($request);
        $compte = $this->getSession()->get(self::Name_Key_Session);

        //var_dump($nameModule, $nameControler,$compte);
       // die();
            
            return $handler->handle($request);
        } else {
            return $this->getResponse()
                            ->withHeader("Location", $url_login)
                            ->withStatus(403);
        }
    }

    private function parseNameModule(ServerRequestInterface $request): string {
        $url = $request->getUri()->getPath();
        preg_match('!/([A-Za-z]+)(.*)!i', $url, $matches);
        if (empty($matches)) {
            return "";
        } else {
            return $matches[1];
        }
    }

    private function parseNameControler(ServerRequestInterface $request): string {
        $route = $this->getRouter()->match($request);
        return $route->getParam("controle");
    }

    private function getRouter(): RouterInterface {
        return $this->router;
    }

    private function getResponse(): ResponseInterface {
        return $this->Response;
    }

    private function getSession(): SessionInterface {
        return $this->Session;
    }

}
