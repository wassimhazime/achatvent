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

class TraitementController extends AbstractController
{

    public function exec(): ResponseInterface
    {
        $this->model->setStatement($this->page);


        $route = $this->router->match($this->request);
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
        }elseif ($action == "message") {
            return $this->message($id);
        }
    }

    public function supprimer($id)
    {
           $conditon = ['id' => $id];
        $etat = $this->model->delete($conditon);
        if ($etat == -1) {
            $r = new \GuzzleHttp\Psr7\Response(404);
            $r->getBody()->write("accès refusé  de supprimer ID  $id");
            return $r;
        } else {
            $this->response->getBody()->write("les données a supprimer de ID  $id");
        }
        return $this->response;
    }

    public function modifier($id)
    {
        $page = $this->page;
        $conditon = ["$page.id" => $id];
        $intentform = $this->model->formDefault( $conditon);
        return $this->render("@T_traitement/modifier_form", ["intent" => $intentform]);
    }

    public function ajouter($id)
    {
        $getInfo = $this->request->getQueryParams();

        if (!isset($getInfo["ajouter"])) {
            
            $intentformselect = $this->model->formSelect();
            
            if (!empty($intentformselect->getMETA_data() )) {
                return $this->render("@T_traitement/ajouter_select", ["intent" => $intentformselect]);
            }
        }

        unset($getInfo["ajouter"]);
        
        $intentform = $this->model->form( $getInfo);
        
        return $this->render("@T_traitement/ajouter_form", ["intent" => $intentform]);
    }

    public function show($id)
    {
        $intent = $this->model->show_id($id);
        return $this->render("@T_show/show_id", ["intent" => $intent]);
    }
        public function message($id)
    {
             $mode = Intent::MODE_SELECT_DEFAULT_NULL;
            $intentshow = $this->model->show($mode, $id);
            return $this->render("@T_show/show_message_id", ["intent" => $intentshow]);

    }
}
