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

class TraitementSendController extends AbstractController {

    public function exec(): ResponseInterface {
        $insert = $this->getRequest()->getParsedBody();

        $data_parent = $this->parseDataPerant_child($insert)["data_parent"];
        $data_child = $this->parseDataPerant_child($insert)["data_child"];


        //  save data parent
        $this->getModel()->setStatement($this->getPage());
        $id_parent = $this->getModel()->setData($data_parent); // formnext Raison sociale
        //  save relation
        $page = substr($this->getPage(), 0, -1); // childe achats => achat
        /// save image 
        $data_child = $this->getFile_Upload()
                ->save_child("TransactionFiles",$this->getRequest(), $data_child, $page);

        /// save data child
        $this->getModel()->setStatement($page);
        $this->getModel()->setData($data_child, $id_parent);


        /// show etem save
        $this->getModel()->setStatement($this->getPage());
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
