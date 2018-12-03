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
use App\AbstractModules\Controller\AbstractShowController;
use App\Modules\Transactions\Model\Model;
use Psr\Http\Message\ResponseInterface;

class ShowController extends AbstractShowController {

    public function __construct(array $Options) {
        parent::__construct($Options);

        $this->setModel(new Model($this->getContainer()->get("pathModel"), $this->getContainer()->get("tmp")));
    }

    public function run($id): ResponseInterface {



        switch (true) {
            case $this->Actions()->is_index():
                return $this->showDataTable("show", $this->getNamesRoute()->ajax());


            case $this->Actions()->is_update():
                return $this->modifier_child($id, "modifier_form_child");


            case $this->Actions()->is_delete():
                return $this->supprimer($id, "les données a supprimer de ID");


            case $this->Actions()->is_show():
                return $this->show($id, "show_id");


            case $this->Actions()->is_message():
                return $this->message($id, "show_message_id");


            case $this->Actions()->is_add():
                return $this->ajouter_child("ajouter_form_child", "ajouter_select");


            default:
                return $this->getResponse()->withStatus(404);
        }
    }

}
