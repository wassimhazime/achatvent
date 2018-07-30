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
use App\AbstractModules\Controller\AbstractTraitementSendController;
use App\Modules\Achats\Model\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TraitementSendController extends AbstractTraitementSendController
{

    public function process(ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface
    {
        $this->setModel(new Model($this->getContainer()->get("pathModel")));
        $response = parent::process($request, $handler);

        if ($response->getStatusCode() === 404) {
            return $response;
        }
        /// save les fichier et gere input file (id_file)
        $request = $this->getFile_Upload()
                ->save(
                    "AchatsFiles",
                    $this->getRequest(),
                    $this->getNameController()
                );
        $insert = $request->getParsedBody();
        $id_parent = $this->getModel()->setData($insert);
        $intent = $this->getModel()->show_id($id_parent);

        return $this->render("@AchatsShow/show_item", ["intent" => $intent]);
    }
}
