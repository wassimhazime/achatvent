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
use App\AbstractModules\Controller\AbstractTraitementShowController;
use App\Modules\Comptable\Model\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TraitementShowController extends AbstractTraitementShowController {

    function __construct(ContainerInterface $container, string $page) {
        parent::__construct($container, $page);
        $this->setModel(new Model($container->get("pathModel")));
    }

    public function process(ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);
         $flag = $this->chargeModel($this->getPage());
        if (!$flag) {
            return $this->getResponse()->withStatus(404);
        }
        $params = $this->getRouter()->match($this->getRequest())->getParams();
        $action = $params["action"];
        $id = $params["id"];


        switch ($action) {
            case "supprimer":
                return $this->supprimer($id, "les données a supprimer de ID");
                break;

            case "modifier":
                return $this->modifier($id, "@ComptableTraitement/modifier_form");
                break;

            case "ajouter":
                $getInfo = $this->getRequest()->getQueryParams();
                if (!isset($getInfo["ajouter"])) {
                    $response = $this->ajouter_select("@ComptableTraitement/ajouter_select");
                    if ($response !== null) {
                        return $response;
                    } else {
                        // if table is mastre (table premier )
                        return $this->ajouter($getInfo, "@ComptableTraitement/ajouter_form");
                    }
                } else {
                    return $this->ajouter($getInfo, "@ComptableTraitement/ajouter_form");
                }
                break;

            case "voir":
                return $this->show($id, "@ComptableShow/show_id");
                break;

            case "message":
                return $this->message($id, "@ComptableShow/show_message_id");
                break;

            default:
                var_dump("errr");
                die("errr");
                break;
        }
    }

}
