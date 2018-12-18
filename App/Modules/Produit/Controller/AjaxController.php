<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Produit\Controller;

use App\AbstractModules\Controller\AbstractAjaxController;
use App\Modules\Produit\Model\Model;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of AjaxController
 *
 * @author wassime
 */
class AjaxController extends AbstractAjaxController
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->setModel(new Model($this->getContainer()->get("pathModel"), $this->getContainer()->get("tmp")));

        parent::process($request, $handler);
         return $this->ajax_js();
    }
}
