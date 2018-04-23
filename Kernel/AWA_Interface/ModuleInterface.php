<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author wassime
 */
namespace Kernel\AWA_Interface;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ModuleInterface
{
    
    
    public function __construct(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container);
    public function addRoute(RouterInterface $router):RouteInterface;
    public function addPathRenderer(string $root):string;
    public function MVC(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container);
}
