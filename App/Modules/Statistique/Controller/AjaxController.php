<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Comptable\Controller;

use Psr\Http\Message\ResponseInterface;

/**
 * Description of AjaxController
 *
 * @author wassime
 */
class AjaxController extends AbstractController {

    //put your code here
    public function exec(): ResponseInterface {

        if ($this->getPage() == "statistique") {
            $query = $this->getRequest()->getParsedBody();
            $st = $this->getModel()->setStatement('statistique');
            $raport = ($st->statistique_pour($query));
            $this->response->getBody()->write($raport);
            return $this->getResponse();
        }

        if ($this->getPage() == "st" or $this->getPage() == "st") {
            $st = $this->model->setStatement('statistique');
            $this->response->getBody()->write($st->statistique_par('bons$achats', "2017-01-01", "2019-01-01"));

            return $this->getResponse();
        }

        $query = $this->getRequest()->getQueryParams();





        $this->getModel()->setStatement($this->getPage());
        $intentshow = $this->getModel()->showAjax(true);

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
        $this->getResponse()->getBody()->write($json);


        return $this->getResponse()->withHeader('Content-Type', 'application/json; charset=utf-8');
    }

}
