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
use App\AbstractModules\Controller\AbstractShowController;
use App\Modules\Transactions\Model\Model;
use Kernel\INTENT\Intent_Form;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function substr;

class ShowController extends AbstractShowController {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
     $this->setModel(new Model($this->getContainer()->get("pathModel")));
        parent::process($request, $handler);
        if ($this->is_Erreur()) {
            return $this->getResponse()->withStatus(404);
        }
        $action = $this->getRoute()->getParam("action");
        $this->Actions()->setAction($action);
        $id = $this->getRoute()->getParam("id");
        return $this->run($id);
    }

    public function run($id): ResponseInterface {
     
        

        switch (true) {
            case $this->Actions()->is_index():
                return $this->showDataTable("show", $this->getNamesRoute()->ajax());


            case $this->Actions()->is_update():
                return $this->modifier($id, "modifier_form");


            case $this->Actions()->is_delete():
                return $this->supprimer($id, "les données a supprimer de ID");


            case $this->Actions()->is_show():
                return $this->show($id, "show_id");


            case $this->Actions()->is_message():
                return $this->message($id, "show_message_id");


            case $this->Actions()->is_add():
                return $this->ajouter("ajouter_form", "ajouter_select");


            default:
                return $this->getResponse()->withStatus(404);
        }
    }

    public function ajouter(string $viewAjoutes, string $viewSelect): ResponseInterface {
        $data_get = $this->getRequest()->getQueryParams();
        $intent_formselect = $this->getModel()->formSelect();
        if (empty($data_get) && !empty($intent_formselect->getMETA_data())) {
            return $this->render($viewSelect, ["intent" => $intent_formselect]);
        } else {

            $this->getModel()->setTable($this->getNameController());
            $intentform = $this->getModel()->form($data_get);

            $page = substr($this->getNameController(), 0, -1); // childe achats => achat

            $this->getModel()->setTable($page);
            $intentformchile = $this->getModel()->form($data_get);

            return $this->render($viewAjoutes, ["intent" => $intentform, "intentchild" => $intentformchile]);
        }
    }

    public function modifier($id, string $view): ResponseInterface {

        $NameController = $this->getNameController();
        $conditon = ["$NameController.id" => $id];
        $intentform = $this->getModel()->formDefault($conditon);





        $pagechild = substr($this->getNameController(), 0, -1); // childe achats => achat
        $this->chargeModel($pagechild);


        // name raisonsocialand id
        $dataselect = $this->getdataselect($intentform);

        $intentformchile = $this->getModel()->form($dataselect);
        return $this->render($view, ["intent" => $intentform, "intentchild" => $intentformchile]);
    }

    private function getdataselect(Intent_Form $intentform) {
        $dataSelectObject = $intentform->getCharge_data()["select"];
        $dataselect = [];
        foreach ($dataSelectObject as $key => $value) {
            $dataselect[$key] = $value[0]->id;
        }
        return $dataselect;
    }

}
