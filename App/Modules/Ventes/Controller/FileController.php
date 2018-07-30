<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Ventes\Controller;

use App\AbstractModules\Controller\AbstractFileController;
use App\Modules\Ventes\Model\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Description of FileController
 *
 * @author wassime
 */
class FileController extends AbstractFileController
{

    public function process(ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface
    {
        $this->setModel(new Model($this->getContainer()->get("pathModel")));

        parent::process($request, $handler);
        $route = $this->getRouter()->match($this->getRequest());
        $files = $this->getFile_Upload()->get($route->getParam("controle"));
        return $this->render("@VentesShow/show_files", ["files" => $files]);
    }
}
