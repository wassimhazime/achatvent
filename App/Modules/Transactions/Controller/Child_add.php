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

class Child_add extends AbstractController {

    public function exec(): ResponseInterface {


        $data = $_POST;
        $perant = [];
        $child = [];
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $child[$key] = $value;
            } else {
                $perant[$key] = $value;
            }
        }
        $new_array = [];

        foreach ($child as $i => $element) {
            foreach ($element as $j => $sub_element) {
                $new_array[$j][$i] = $sub_element;
            }
        }

        $page = "achat"; // childe achats => achat

        $this->model->setStatement($page);
      


       
            $intent = $this->model->setData($new_array,$perant["parent_id"]);
            //  return $this->render("@show/show_item", ["intent" => $intent]);
  


        die();
    }

}
