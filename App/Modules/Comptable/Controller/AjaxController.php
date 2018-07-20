<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Comptable\Controller;

use App\AbstractModules\Controller\AbstractAjaxController;
use App\Modules\Comptable\Model\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Description of AjaxController
 *
 * @author wassime
 */
class AjaxController extends AbstractAjaxController {

    function __construct(ContainerInterface $container, string $page) {
        parent::__construct($container, $page);
        $this->setModel(new Model($container->get("pathModel")));
    }

    public function process(ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface {

        parent::process($request, $handler);
        return $this->ajax_js();
    }

}
