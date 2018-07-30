<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\CRM\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */

use App\AbstractModules\Controller\AbstractTraitementSendController;
use App\Modules\CRM\Model\Model;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function sleep;

class TraitementSendController extends AbstractTraitementSendController
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->setModel(new Model($this->getContainer()->get("pathModel")));
        parent::process($request, $handler);
        if ($this->is_Erreur()) {
            return $this->getResponse()->withStatus(404);
        }
       /// save les fichier et gere input file (id_file)
        $request = $this->getFile_Upload()
                ->save(
                    "CRMFiles",
                    $this->getRequest(),
                    $this->getNameController()
                );
        
        
        $insert = $request->getParsedBody();
        $id_parent = $this->getModel()->setData($insert);
        $intent = $this->getModel()->show_id($id_parent);
        sleep(1);
        return $this->render("@CRMShow/show_item", ["intent" => $intent]);
    }
}
