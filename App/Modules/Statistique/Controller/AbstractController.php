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

namespace App\Modules\Statistique\Controller;

use App\Modules\Statistique\Model\Model;



use Kernel\Controller\Controller;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractController extends Controller {

    function __construct(ContainerInterface $container) {
        parent::__construct($container);
       $this->setModel( new Model($container->get( "pathModel")));

     
       
        
    }

}
