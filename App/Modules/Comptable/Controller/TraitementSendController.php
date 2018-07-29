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
use App\AbstractModules\Controller\AbstractTraitementSendController;
use App\Modules\Comptable\Model\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TraitementSendController extends AbstractTraitementSendController {

    function __construct(ContainerInterface $container) {
        parent::__construct($container);
        $this->setModel(new Model($container->get("pathModel")));
    }

  

    public function process(ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);
        /// save les fichier et gere input file (id_file)
        $request = $this->getFile_Upload()
                ->save(
                "ComptableFiles", $this->getRequest(), $this->getPage()
        );

        $insert = $request->getParsedBody();

        $flag = $this->chargeModel($this->getPage());
        if (!$flag) {
            return $this->getResponse()->withStatus(404);
        }
        $id_parent = $this->getModel()->setData($insert);
        $intent = $this->getModel()->show_id($id_parent);
        
        return $this->render("@ComptableShow/show_item", ["intent" => $intent]);
    }

}
