<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Transactions\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */

use App\AbstractModules\Controller\AbstractTraitementShowController;
use App\Modules\Transactions\Model\Model;
use Kernel\INTENT\Intent_Form;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function substr;

class TraitementShowController extends AbstractTraitementShowController
{

 

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
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
                return $this->modifier($id, "@TransactionsTraitement/modifier_form");
                break;

            case "ajouter":
                $getInfo = $this->getRequest()->getQueryParams();
                if (!isset($getInfo["ajouter"])) {
                    $response = $this->ajouter_select("@TransactionsTraitement/ajouter_select");
                    if ($response !== null) {
                        return $response;
                    } else {
                        // if table is mastre (table premier )
                        return $this->ajouter($getInfo, "@TransactionsTraitement/ajouter_form");
                    }
                } else {
                    return $this->ajouter($getInfo, "@TransactionsTraitement/ajouter_form");
                }
                break;

            case "voir":
                return $this->show($id, "@TransactionsShow/show_id");
                break;

            case "message":
                return $this->message($id, "@TransactionsShow/show_message_id");
                break;

            default:
                return   $this->getResponse()->withStatus(404);
                break;
        }
    }

    public function modifier($id, string $view): ResponseInterface
    {
        $page = $this->getPage();
        $conditon = ["$page.id" => $id];
        $intentform = $this->getModel()->formDefault($conditon);





        $pagechild = substr($this->getPage(), 0, -1); // childe achats => achat
        $this->getModel()->setStatement($pagechild);


        // name raisonsocialand id
        $dataselect = $this->getdataselect($intentform);

        $intentformchile = $this->getModel()->form($dataselect);
        return $this->render($view, ["intent" => $intentform, "intentchild" => $intentformchile]);
    }

    public function ajouter_select(string $view)
    {
        $intentformselect = $this->getModel()->formSelect();

        if (!empty($intentformselect->getMETA_data())) {
            return $this->render($view, ["intent" => $intentformselect]);
        }
    }

    public function ajouter($getInfo, string $view): ResponseInterface
    {




        unset($getInfo["ajouter"]);
        $this->getModel()->setTable($this->getNameController());
        $intentform = $this->getModel()->form($getInfo);

        $page = substr($this->getNameController(), 0, -1); // childe achats => achat

        $this->getModel()->setTable($page);
        $intentformchile = $this->getModel()->form($getInfo);

        return $this->render($view, ["intent" => $intentform, "intentchild" => $intentformchile]);
    }

    private function getdataselect(Intent_Form $intentform)
    {
        $dataSelectObject = $intentform->getCharge_data()["select"];
        $dataselect = [];
        foreach ($dataSelectObject as $key => $value) {
            $dataselect[$key] = $value[0]->id;
        }
        return $dataselect;
    }
}
