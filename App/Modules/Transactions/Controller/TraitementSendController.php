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
use App\AbstractModules\Controller\AbstractTraitementSendController;

;

use App\Modules\Transactions\Model\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use function preg_match;
use function str_replace;
use function substr;

class TraitementSendController extends AbstractTraitementSendController {

    function __construct(ContainerInterface $container, string $page) {
        parent::__construct($container, $page);
        $this->setModel(new Model($container->get("pathModel")));
    }

    public function process(ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);

        // get data insert merge par parent et child
        $insert = $this->getRequest()->getParsedBody();


        // parse data 
        $parseData = $this->parseDataPerant_child($insert);
        $data_parent = $parseData["data_parent"];
        $data_child = $parseData["data_child"];


        //  save data parent
        $flag = $this->chargeModel($this->getPage());
        if (!$flag) {
            return $this->getResponse()->withStatus(404);
        }
        // insert data
        // $id_parent pour gere relation et data lier(exemple raison social)
        $id_parent = $this->getModel()->setData($data_parent);

        /*         * ************************* */
        //  save relation
        /// childe achats => achat
        $page = substr($this->getPage(), 0, -1);
        /// save image 
        $data_child = $this->getFile_Upload()
                ->save_child("TransactionFiles", $this->getRequest(), $data_child, $page);

        /// save data child
        $flag = $this->chargeModel($page);
        if (!$flag) {
            /// 404 not found
           return $this->getResponse()->withStatus(404);
        }
        $this->getModel()->setData($data_child, $id_parent);


        /// show etem save
        $flag = $this->chargeModel($this->getPage());
        if (!$flag) {
            /// 404 not found
            return $this->render("404", ["_page" => "404"]);
        };
        $intent = $this->getModel()->show_id($id_parent);
        return $this->render("@TransactionsShow/show_item", ["intent" => $intent]);
    }

    private function parseDataPerant_child(array $data_set): array {

        $data_parent = [];
        $data_child = [];

        // parse data => dataperant and datachild
        foreach ($data_set as $key => $data) {

            if (preg_match("/\_child\b/i", $key)) {
                $data_child[str_replace("_child", "", $key)] = $data;
            } else {
                $data_parent[$key] = $data;
            }
        }


        // sort array data child

        $data_child_sort = [];
        foreach ($data_child as $i => $element) {
            foreach ($element as $j => $sub_element) {
                $data_child_sort[$j][$i] = $sub_element;
            }
        }

        return [
            "data_parent" => $data_parent,
            "data_child" => $data_child_sort
        ];
    }

}
