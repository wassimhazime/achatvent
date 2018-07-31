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
use App\AbstractModules\Controller\AbstractTraitementShowController;
use App\Modules\CRM\Model\Model;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TraitementShowController extends AbstractTraitementShowController {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        $this->setModel(new Model($this->getContainer()->get("pathModel")));
        parent::process($request, $handler);

        if ($this->is_Erreur()) {
            return $this->getResponse()->withStatus(404);
        }

        $action = $this->getRoute()->getParam("action");
        $id = $this->getRoute()->getParam("id");


        switch ($action) {
            case "supprimer":
                return $this->supprimer($id, "les données a supprimer de ID");
                break;

            case "modifier":
                return $this->modifier($id, "@CRMTraitement/modifier_form");
                break;

            case "ajouter":
                $getInfo = $this->getRequest()->getQueryParams();
                if (!isset($getInfo["ajouter"])) {
                    $response = $this->ajouter_select("@CRMTraitement/ajouter_select");
                    if ($response !== null) {
                        return $response;
                    } else {
                        // if table is mastre (table premier )
                        return $this->ajouter($getInfo, "@CRMTraitement/ajouter_form");
                    }
                } else {
                    return $this->ajouter($getInfo, "@CRMTraitement/ajouter_form");
                }
                break;

            case "voir":
                return $this->show($id, "@CRMShow/show_id");
                break;

            case "message":
                return $this->message($id, "@CRMShow/show_message_id");
                break;

            default:
                return $this->getResponse()->withStatus(404);
                break;
        }
    }

}
