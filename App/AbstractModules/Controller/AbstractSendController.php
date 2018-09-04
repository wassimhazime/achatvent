<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\AbstractModules\Controller;

use Psr\Http\Message\ResponseInterface;
use function preg_match;
use function str_replace;
use function substr;

/**
 * Description of PostController
 *
 * @author wassime
 */
abstract class AbstractSendController extends AbstractController {

    public function send_data(string $view_show, string $routeFile = ""): ResponseInterface {
        if ($this->is_Erreur()) {
            return $this->getResponse()->withStatus(404);
        }

        /**
         * save les files
         * get id files save
         */
        $file_Upload = $this->getFile_Upload();
        $file_Upload->setPreffix($this->getNameController());
        $uploadedFiles = $this->getRequest()->getUploadedFiles();
        $keyFilesSave = $file_Upload->save($routeFile, $uploadedFiles);


        /**
         * get data post
         * merge data post and id file save
         */
        $POST = $this->getRequest()->getParsedBody();
        $insert = array_merge($POST, $keyFilesSave);
        /**
         * set data to database
         */
        $id_parent = $this->getModel()->setData($insert);

        /**
         * get data save to model
         */
        $intent = $this->getModel()->show_styleForm($id_parent);
        /**
         * show data get par model
         */
        return $this->render($view_show, ["intent" => $intent]);
    }

    ///////////////////////////////////////////////////////////////////
    public function send_data_ParantChild(string $view_show, string $routeFile): ResponseInterface {
        if ($this->is_Erreur()) {
            return $this->getResponse()->withStatus(404);
        }
        $request = $this->getRequest();



        // get data insert merge par parent et child
        $insert = $request->getParsedBody();


        // parse data
        $parseData = $this->parseDataPerant_child($insert);
        $data_parent = $parseData["data_parent"];
        $data_child = $parseData["data_child"];


        //  save data parent
        $table_parent = $this->getNameController();
        $this->chargeModel($table_parent);

        // insert data
        // $id_parent pour gere relation et data lier(exemple raison social)
        $id_parent = $this->getModel()->setData($data_parent);

        /*         * ************************* */
        //  save relation
        /// save image

        $file_Upload = $this->getFile_Upload();
        $file_Upload->setPreffix($this->getNameController());
        $uploadedFiles = $this->getRequest()->getUploadedFiles();
        /**
         * keyFilesSaves
         * $index int ==> row qui is file save
         * value => keyFilesSave array
         *   name input file and data inpute
         */
        $keyFilesSaves = $file_Upload->save_child($routeFile, $uploadedFiles);

        foreach ($keyFilesSaves as $index => $keyFilesSave) {

            foreach ($keyFilesSave as $nameinput => $keyfile) {

                $data_child[$index][$nameinput] = $keyfile;
            }
        }


        /// childe achats => achat
        $Controller_child = substr($this->getNameController(), 0, -1);

        /// save data child
        $this->chargeModel($Controller_child);

        $this->getModel()->setData($data_child, $table_parent, $id_parent);


        /// show etem save
        $this->chargeModel($this->getNameController());

        $intent = $this->getModel()->show_styleForm($id_parent);

        return $this->render($view_show, ["intent" => $intent]);
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
