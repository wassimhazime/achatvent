<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Statistique\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class globalController extends AbstractController
{

    public function process(ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface
    {
        $this->setModel(new \App\Modules\Statistique\Model\Model($this->getContainer()->get("pathModel")));

        parent::process($request, $handler);
        
        $st = $this->getModel()->action('statistique');
        $charge = $st->chargeDataSelect();
        return $this->render("global", ["charge" => $charge]);
    }
}
