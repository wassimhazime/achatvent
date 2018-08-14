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
        $model = $this->getModel();
        $schema = $model->getschema();

        $data_get = $this->getRequest()->getQueryParams();
        $META_data = $schema->getCOLUMNS_META(["Key" => "MUL"]);

        if (empty($data_get) && !empty($META_data)) {
            $select = $model->get_Data_FOREIGN_KEY();
            $intent_formselect = new Intent_Form();
            $intent_formselect->setCOLUMNS_META($META_data);
            $intent_formselect->setCharge_data_select($select);
            return $this->render($viewSelect, ["intent" => $intent_formselect]);
        } else {


            $model = $this->getModel();
            $schema = $model->getschema();
            $META_data = $schema->getCOLUMNS_META();
            $select = $model->get_Data_FOREIGN_KEY($data_get);
            $multiSelect = $model->dataChargeMultiSelectIndependent($data_get);

            $intent_form = new Intent_Form();
            $intent_form->setCOLUMNS_META($META_data);
            $intent_form->setCharge_data_select($select);
            $intent_form->setCharge_data_multiSelect($multiSelect);




            $NameControllerchild = substr($this->getNameController(), 0, -1); // childe achats => achat
            $this->getModel()->setTable($NameControllerchild);

            $model = $this->getModel();
            $schema = $model->getschema();
            $META_data = $schema->getCOLUMNS_META();
            $select = $model->get_Data_FOREIGN_KEY($data_get);
            $multiSelect = $model->dataChargeMultiSelectIndependent($data_get);

            $intentformchile = new Intent_Form();
            $intentformchile->setCOLUMNS_META($META_data);
            $intentformchile->setCharge_data_select($select);
            $intentformchile->setCharge_data_multiSelect($multiSelect);

            return $this->render($viewAjoutes, ["intent" => $intent_form, "intentchild" => $intentformchile]);
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
