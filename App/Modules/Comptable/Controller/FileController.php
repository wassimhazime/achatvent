<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Comptable\Controller;

use App\AbstractModules\Controller\AbstractFileController;
use App\Modules\Comptable\Model\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Description of FileController
 *
 * @author wassime
 */
class FileController extends AbstractFileController {

    function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->setModel(new Model($container->get("pathModel")));
    }

    public function process(ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);
        $files = $this->getFile_Upload()->get($this->getPage());
        return $this->render("@ComptableShow/show_files", ["files" => $files]);
    }

}
