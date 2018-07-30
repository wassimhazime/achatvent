<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Ventes\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */
use App\AbstractModules\Controller\AbstractTraitementShowController;
use App\Modules\Ventes\Model\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TraitementShowController extends AbstractTraitementShowController
{

 

    public function process(ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface
    {
        $this->setModel(new Model($this->getContainer()->get("pathModel")));
        $response = parent::process($request, $handler);
        if ($response->getStatusCode() === 404) {
            return $response;
        }
        $params = $this->getRouter()->match($this->getRequest())->getParams();
        $action = $params["action"];
        $id = $params["id"];


        switch ($action) {
            case "supprimer":
                return $this->supprimer($id, "les données a supprimer de ID");
                break;

            case "modifier":
                return $this->modifier($id, "@VentesTraitement/modifier_form");
                break;

            case "ajouter":
                $getInfo = $this->getRequest()->getQueryParams();
                if (!isset($getInfo["ajouter"])) {
                    $response = $this->ajouter_select("@VentesTraitement/ajouter_select");
                    if ($response !== null) {
                        return $response;
                    } else {
                        // if table is mastre (table premier )
                        return $this->ajouter($getInfo, "@VentesTraitement/ajouter_form");
                    }
                } else {
                    return $this->ajouter($getInfo, "@VentesTraitement/ajouter_form");
                }
                break;

            case "voir":
                return $this->show($id, "@VentesShow/show_id");
                break;

            case "message":
                return $this->message($id, "@VentesShow/show_message_id");
                break;

            default:
                return   $this->getResponse()->withStatus(404);
                break;
        }
    }
}
