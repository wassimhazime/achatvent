<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\CRM\Controller;

use App\AbstractModules\Controller\AbstractFileController;
use App\Modules\CRM\Model\Model;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of FileController
 *
 * @author wassime
 */
class FileController extends AbstractFileController
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->setModel(new Model($this->getContainer()->get("pathModel")));

        parent::process($request, $handler);
        
//         if($this->is_Erreur("Controller")){
//            return $this->getResponse()->withStatus(404);
//        }
        $route = $this->getRouter()->match($this->getRequest());
        $files = $this->getFile_Upload()->get($route->getParam("controle"));
        return $this->render("@CRMShow/show_files", ["files" => $files]);
    }
}
