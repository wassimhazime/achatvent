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

    function __construct(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container, string $page) {
        parent::__construct($request, $response, $container, $page);
        $this->setModel(new Model($container->get("pathModel")));
    }

    public function exec(): ResponseInterface {


        /// save les fichier et gere input file (id_file)
        $request = $this->getFile_Upload()
                ->save(
                "ComptableFiles",
                        $this->getRequest(),
                        $this->getPage()
        );

        $insert = $request->getParsedBody();

        $flag = $this->chargeModel($this->getPage());
        if (!$flag) {
            /// 404 not found
            return $this->render("404", ["_page" => "404"]);
        }
        $intent = $this->getModel()->setData($insert);
        return $this->render("@ComptableShow/show_item", ["intent" => $intent]);
    }

}
