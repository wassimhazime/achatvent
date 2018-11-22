<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Achats\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */

use App\AbstractModules\Controller\AbstractSendController;
use App\Modules\Achats\Model\Model;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SendController extends AbstractSendController {

   public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
           $this->setModel(new Model($this->getContainer()->get("pathModel"),$this->getContainer()->get("tmp")));
        parent::process($request, $handler);
        return $this->send_data("show_item", $this->getNamesRoute()->files());
    }

}
