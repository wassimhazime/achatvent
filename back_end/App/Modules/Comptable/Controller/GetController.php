<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Comptable\Controller;

/**
 * Description of GetController
 *
 * @author wassime
 */
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Kernel\INTENT\Intent;

class GetController extends Controller {

    public function exec(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $route = $this->router->match($request);
        $params = $route->getParams();
        $page = $params["controle"];

        if ($page == "" or $page == "index") {
            $data = $this->renderer->render("@achat/facture", ["table" => ""]);
            $response->getBody()->write($data);
            return $response;
        }

        if ($page == "statistique" or $page == "statistique") {

            $st = $this->model->setStatement('statistique');
            $charge = $st->chargeDataSelect();

            $data = $this->renderer->render("@achat/statistique", ["charge" => $charge]);
            $response->getBody()->write($data);
            return $response;
        }

        if ($page == "st" or $page == "st") {

            $st = $this->model->setStatement('statistique');



            $response->getBody()->write($st->statistique_par("achats", "2017-01-01", "2019-01-01"));

            return $response;
        }


        $query = $request->getQueryParams();

        $this->model->setStatement($page);
        if (isset($query["supprimer"])) {
            return $this->supprimer($query, $request, $response);
        } elseif (isset($query["modifier"])) {
            return $this->modifier($page, $query, $request, $response);
        } elseif (isset($query["ajouter"])) {
            return $this->ajouter($query, $response);
        } elseif (isset($query["imageview"])) {
            $id_image = $query["imageview"];
            return $this->File_Upload->get($id_image);
        } else {

            return $this->show($query, $response);
        }
    }

    public function supprimer($query, $request, $response) {
        $conditon = ['id' => $query['id']];
        $this->model->delete($conditon);
        $url = $request->getUri()->getPath();
        return $response->withStatus(301)->withHeader('Location', $url);
    }

    public function modifier($page, $query, $request, $response) {

        $conditon = ["$page.id" => $query['id']];
        $intentform = $this->model->formDefault(Intent::MODE_FORM, $conditon);
        $form = $this->FactoryTAG->FormHTML($intentform);  //twig

        $data = $this->renderer->render("@achat/add", ["form" => $form, "table" => '$table']);
        $response->getBody()->write($data);
        return $response;
    }

    public function ajouter($query, $response) {
        if ($query["ajouter"] != "Valider") {
            $intentformselect = $this->model->formSelect(Intent::MODE_FORM);
            if (!empty($intentformselect->getEntitysSchema()->getFOREIGN_KEY())) {
                $form = $this->FactoryTAG->FormHTML($intentformselect);  //twig
                $data = $this->renderer->render("@achat/select", ["form" => $form]);
                $response->getBody()->write($data);
                return $response;
            }
        }
        unset($query["ajouter"]);


        $intentform = $this->model->form(Intent::MODE_FORM, $query);
        $form = $this->FactoryTAG->FormHTML($intentform);  //twig
        $data = $this->renderer->render("@achat/add", ["form" => $form]);
        $response->getBody()->write($data);
        return $response;
    }

    public function show($query, $response) {
        if (isset($query["s"])) {
            $select = $query["s"];
        } else {
            $select = "dd";
        }
        switch ($select) {
            case "dm":
                $mode = Intent::MODE_SELECT_DEFAULT_MASTER;

                break;
            case "da":

                $mode = Intent::MODE_SELECT_DEFAULT_ALL;
                break;
            case "dd":

                $mode = Intent::MODE_SELECT_DEFAULT_DEFAULT;
                break;
            case "dn":

                $mode = Intent::MODE_SELECT_DEFAULT_NULL;
                break;


            case "mm":
                $mode = Intent::MODE_SELECT_MASTER_MASTER;

                break;
            case "ma":

                $mode = Intent::MODE_SELECT_MASTER_ALL;
                break;
            case "am":

                $mode = Intent::MODE_SELECT_ALL_MASTER;
                break;
            case "aa":
                $mode = Intent::MODE_SELECT_ALL_ALL;

                break;
            case "an":
                $mode = Intent::MODE_SELECT_ALL_NULL;

                break;
            case "mn":

                $mode = Intent::MODE_SELECT_MASTER_NULL;
                break;
            default:
                $mode = Intent::MODE_SELECT_DEFAULT_DEFAULT;
                break;
        }


        $intentshow = $this->model->show($mode, true);

        $table = $this->FactoryTAG->tableHTML($intentshow); //twig

        $data = $this->renderer->render("@achat/show", ["table" => $table]);
        $response->getBody()->write($data);
        return $response;
    }

}
