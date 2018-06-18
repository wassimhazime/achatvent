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
use Kernel\INTENT\Intent;
use Psr\Http\Message\ResponseInterface;

class TraitementShowController extends AbstractController {

    public function exec(): ResponseInterface {
        $this->getModel()->setStatement($this->getPage());


        $route = $this->getRouter()->match($this->getRequest());
        $params = $route->getParams();
        $action = $params["action"];
        $id = $params["id"];




        if ($action == "supprimer") {
            return $this->supprimer($id);
        } elseif ($action == "modifier") {
            return $this->modifier($id);
        } elseif ($action == "ajouter") {
            return $this->ajouter($id);
        } elseif ($action == "voir") {
            return $this->show($id);
        } elseif ($action == "message") {
            return $this->message($id);
        }
    }

    public function supprimer($id) {
        $conditon = ['id' => $id];
        $etat = $this->getModel()->delete($conditon);
        if ($etat == -1) {
            $r = new \GuzzleHttp\Psr7\Response(404);
            $r->getBody()->write("accès refusé  de supprimer ID  $id");
            return $r;
        } else {
            $this->getResponse()->getBody()->write("les données a supprimer de ID  $id");
        }
        return $this->getResponse();
    }

    public function modifier($id) {
        $page = $this->page;
        $conditon = ["$page.id" => $id];
        $intentform = $this->model->formDefault($conditon);
        return $this->render("@T_traitement/modifier_form", ["intent" => $intentform]);
    }

    public function ajouter($id) {
        $getInfo = $this->getRequest()->getQueryParams();

        if (!isset($getInfo["ajouter"])) {

            $intentformselect = $this->getModel()->formSelect();

            if (!empty($intentformselect->getMETA_data())) {
                return $this->render("@TransactionsTraitement/ajouter_select", ["intent" => $intentformselect]);
            }
        }

        unset($getInfo["ajouter"]);

        $intentform = $this->getModel()->form($getInfo);

        return $this->render("@TransactionsTraitement/ajouter_form", ["intent" => $intentform]);
    }

    public function show($id) {
        $intent = $this->getModel()->show_id($id);
        return $this->render("@TransactionsShow/show_id", ["intent" => $intent]);
    }

    public function message($id) {
        $mode = Intent::MODE_SELECT_DEFAULT_NULL;

        $intentshow = $this->getModel()->show_in($mode, $id);
        
        return $this->render("@TransactionsShow/show_message_id", ["intent" => $intentshow]);
    }

}
