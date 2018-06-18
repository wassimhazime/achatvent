<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Transactions\Controller;

use Psr\Http\Message\ResponseInterface;

/**
 * Description of AjaxController
 *
 * @author wassime
 */
class AjaxController extends AbstractController {

    //put your code here
    public function exec(): ResponseInterface {
        $this->getModel()->setStatement($this->getPage());
        $query = $this->getRequest()->getQueryParams();

        $modeshow = $this->getModeShow($query);
        $modeintent = $modeshow["modeIntent"];

        $intentshow = $this->getModel()->showAjax($modeintent, true);
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
