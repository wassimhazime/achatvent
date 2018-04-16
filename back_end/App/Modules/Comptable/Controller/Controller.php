<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author wassime
 */

namespace App\Modules\Comptable\Controller;

use App\Modules\Comptable\Model\Model;
use Kernel\html\FactoryTAG;
use Kernel\html\File_Upload;

use Kernel\Renderer\TwigRenderer;
use Kernel\Router\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class  Controller {

    public $model;
    public $FactoryTAG;
    public $File_Upload;
    public $renderer;
    public $controller;
    public $route;

    function __construct(ContainerInterface $container) {

        $this->router = $container->get(Router::class);
        $this->model = $container->get(Model::class);
        $this->FactoryTAG = $container->get(FactoryTAG::class);
        $this->renderer = $container->get(TwigRenderer::class);
        $this->File_Upload = $container->get(File_Upload::class);
    }
    abstract function exec(ServerRequestInterface $request, ResponseInterface $response):ResponseInterface;
    
   
    

}
