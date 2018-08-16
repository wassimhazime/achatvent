<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\AbstractModules\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */
use Kernel\INTENT\Intent_Form;
use Kernel\INTENT\Intent_Show;
use Psr\Http\Message\ResponseInterface;
use function preg_match;

abstract class AbstractShowController extends AbstractController {

    protected function showDataTable(string $name_views, string $nameRouteGetDataAjax): ResponseInterface {

        if ($this->is_Erreur()) {
            return $this->getResponse()->withStatus(404);
        }

        $query = $this->getRequest()->getQueryParams();
        $modeshow = $this->getModeShow($query);
        $modeintent = $modeshow["modeIntent"];

        $data = [
            "Html_or_Json" => $modeshow["type"],
            "btnDataTable" => $this->btn_DataTable($query)["btn"],
            "jsCharges" => $this->btn_DataTable($query)["jsCharges"],
            "modeintentpere" => $modeintent[0],
            "modeintentenfant" => $modeintent[1]
        ];


        if ($modeshow["type"] === "HTML") {
            $data["intent"] = $this->getModel()->show($modeintent, true);
        } elseif ($modeshow["type"] === "json") {
            $url = $this->getRouter()
                    ->generateUri($nameRouteGetDataAjax, ["controle" => $this->getNameController()]);

            $get = "?" . $this->getRequest()->getUri()->getQuery();
            $data["ajax"] = $url . $get;
        }
        return $this->render($name_views, $data);
    }

    private function btn_DataTable(array $modeHTTP): array {

        $param = "pageLength colvis";
        $jsCharge = [];
        if (isset($modeHTTP["copier"]) && $modeHTTP["copier"] == "on") {
            $param .= " copyHtml5";
            $jsCharge["copier"] = true;
        }
        if (isset($modeHTTP["pdf"]) && $modeHTTP["pdf"] == "on") {
            $param .= " pdfHtml5";
            $jsCharge["pdf"] = true;
        }
        if (isset($modeHTTP["excel"]) && $modeHTTP["excel"] == "on") {
            $param .= " excelHtml5";
            $jsCharge["excel"] = true;
        }
        if (isset($modeHTTP["impression"]) && $modeHTTP["impression"] == "on") {
            $param .= " print";
            $jsCharge["print"] = true;
        }
        $param .= " control";

        return ["btn" => $param, "jsCharges" => $jsCharge];
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function supprimer($id, string $view): ResponseInterface {

        $conditon = ['id' => $id];

        $url_id_file = $this->getModel()->get_idfile($id);

        preg_match('!(.+)'
                . 'data-regex="/(.+)/"'
                . '(.+)!i', $url_id_file, $matches);

        $etat = $this->getModel()->delete($conditon);
        if ($etat == -1) {
            $r = $this->getResponse()->withStatus(406);
            $r->getBody()->write("accès refusé  de supprimer ID  $id");
            return $r;
        } else {
            $this->getResponse()->getBody()->write("$view  $id");

            if (!empty($matches) && isset($matches[2])) {
                $this->getFile_Upload()->delete($matches[2]);
            }
        }

        return $this->getResponse();
    }

    public function modifier($id_save, string $view): ResponseInterface {
        

        $modeselect = $this->getModel()::MODE_SELECT_ALL_MASTER;
        $model = $this->getModel();
        
        $schema = $model->getschema();

        $Entitys = $model->find_by_id($id_save, $schema, $modeselect);

        if ($Entitys->is_Null()) {
            die("<h1>donnees vide car je ne peux pas insérer données  doublons ou vide </h1> ");
        }

        $intent_Form = new Intent_Form();
        $intent_Form->setDefault_Data($Entitys);
        $id_FOREIGN_KEYs = $model->get_id_FOREIGN_KEYs($id_save);


        $intent_Form->setCharge_data_select($model->get_Data_FOREIGN_KEY($id_FOREIGN_KEYs));
        $intent_Form->setCharge_data_multiSelect($model->dataChargeMultiSelectIndependent($id_FOREIGN_KEYs, $modeselect));
        $intent_Form->setCOLUMNS_META($schema->getCOLUMNS_META());







        return $this->render($view, ["intent" => $intent_Form]);
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

            $META_data = $schema->getCOLUMNS_META();
            $select = $model->get_Data_FOREIGN_KEY($data_get);
            $multiSelect = $model->dataChargeMultiSelectIndependent($data_get);

            $intent_form = new Intent_Form();
            $intent_form->setCOLUMNS_META($META_data);
            $intent_form->setCharge_data_select($select);
            $intent_form->setCharge_data_multiSelect($multiSelect);


            return $this->render($viewAjoutes, ["intent" => $intent_form]);
        }
    }

    public function show($id, string $view): ResponseInterface {
        $intent = $this->getModel()->show_styleForm($id);
        return $this->render($view, ["intent" => $intent]);
    }

    public function message($id, string $view): ResponseInterface {

        $mode = $this->getModel()::MODE_SELECT_DEFAULT_NULL;

        $intentshow = $this->getModel()->show_in($mode, $id);

        return $this->render($view, ["intent" => $intentshow]);
    }

}
