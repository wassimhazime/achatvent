<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Midd_affiche_PSR15
 *
 * @author wassime
 */
namespace Kernel\Middleware\Middleware_PSR15;

use Kernel\Middleware\InterfaceMiddleware\PSR15\MiddlewareInterface;
use Kernel\Middleware\InterfaceMiddleware\PSR15\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Midd_affiche_PSR15 implements MiddlewareInterface
{
    
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response=$handler->handle($request);
        $response->getBody()->write(" affiche PSR 15 1 ");
        return $response;
    }
}
