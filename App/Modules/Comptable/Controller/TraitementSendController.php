<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Comptable\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TraitementSendController extends AbstractController {

    public function exec(): ResponseInterface {
        $request = $this->getRequest();
        $request = $this->getFile_Upload()
                ->save($request, $this->getPage());
        $insert = $request->getParsedBody();
        
        $this->getModel()->setStatement($this->getPage());
        $intent = $this->getModel()->setData($insert);
        return $this->render("@ComptableShow/show_item", ["intent" => $intent]);
    }

}
