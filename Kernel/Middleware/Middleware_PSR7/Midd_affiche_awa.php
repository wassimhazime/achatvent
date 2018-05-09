<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Midd_affiche_wassim
 *
 * @author wassime
 */
namespace Kernel\Middleware\Middleware\Middleware_PSR7;

use Kernel\Middleware\InterfaceMiddleware\PSR7\Interface_PSR7;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Midd_affiche_awa implements Interface_PSR7
{
//put your code here
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        $response->getBody()->write(" affiche awa ");
        return $next($request, $response);
    }
}