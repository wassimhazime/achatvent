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

use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use Psr\Container\ContainerInterface;

interface ModuleInterface {

    public function __construct(ContainerInterface $container);

    public function addPathRenderer(RendererInterface $renderer, string $pathModules);

    public function addRoute(RouterInterface $router,array $middlewares);

    public function getMenu(): array;
}
