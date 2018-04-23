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
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AjaxController extends AbstractController {

    public function exec(): ResponseInterface {




        if ($this->page == "statistique") {
            $query = $this->request->getParsedBody();
            $st = $this->model->setStatement('statistique');
            $raport = ($st->statistique_pour($query));
            $this->response->getBody()->write($raport);
            return $this->response;
        }

        if ($this->page == "st" or $this->page == "st") {

            $st = $this->model->setStatement('statistique');
            $this->response->getBody()->write($st->statistique_par('bons$achats', "2017-01-01", "2019-01-01"));

            return $this->response;
        }

        $query = $this->request->getQueryParams();





        $this->model->setStatement($this->page);
        $intentshow = $this->model->showAjax(true);

        $entity = ($intentshow->getEntitysDataTable());
        $data = \Kernel\Tools\Tools::entitys_TO_array($entity);

        $titles = [];
        $dataSets = [];
        foreach ($data as $rom) {
            $title = [];
            $dataSet = [];
            foreach ($rom as $t => $d) {
                $title[] = ["title" => $t];
                $dataSet[] = $d;
            }
            $titles = $title;
            $dataSets[] = $dataSet;
        }

        $json = \Kernel\Tools\Tools::json(["data" => $data, "titles" => $titles, "dataSet" => $dataSets]);
        $this->response->getBody()->write($json);
        return $this->response;
    }

}
