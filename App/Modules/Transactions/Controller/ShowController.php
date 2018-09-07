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

 public function __construct(array $Options) {
        parent::__construct($Options);
       
        $this->setModel(new Model($this->getContainer()->get("pathModel")));
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

    protected function ajouter(string $viewAjoutes, string $viewSelect): ResponseInterface {
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

    protected function modifier($id_save, string $view): ResponseInterface {


        $model = $this->getModel();
        $modeselect = $model::MODE_SELECT_ALL_MASTER;

        $schema = $model->getschema();

        $Entitys = $model->find_by_id($id_save, $modeselect, $schema);

        if ($Entitys->is_Null()) {
            die("<h1>donnees vide car je ne peux pas insérer données  doublons ou vide </h1> ");
        }

        $intent_Form = new Intent_Form();
        $intent_Form->setDefault_Data($Entitys);
        $id_FOREIGN_KEYs = $model->get_id_FOREIGN_KEYs($id_save);


        $intent_Form->setCharge_data_select($model->get_Data_FOREIGN_KEY($id_FOREIGN_KEYs));
        $intent_Form->setCharge_data_multiSelect($model->dataChargeMultiSelectIndependent($id_FOREIGN_KEYs, $modeselect));
        $intent_Form->setCOLUMNS_META($schema->getCOLUMNS_META());



        //****************************************//

        $Controllerchild = substr($this->getNameController(), 0, -1); // childe achats => achat
        $this->chargeModel($Controllerchild);
        $model_Child = $this->getModel();
        $schema_Child = $model_Child->getschema();

        $intent_formChile = new Intent_Form();
        $intent_formChile->setCharge_data_select($model_Child->get_Data_FOREIGN_KEY($id_FOREIGN_KEYs));
        $intent_formChile->setCharge_data_multiSelect($model_Child->dataChargeMultiSelectIndependent($id_FOREIGN_KEYs, $modeselect));
        $intent_formChile->setCOLUMNS_META($schema_Child->getCOLUMNS_META());


        return $this->render($view, ["intent" => $intent_Form, "intentchild" => $intent_formChile]);
    }

}
