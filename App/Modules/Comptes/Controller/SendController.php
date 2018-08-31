<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Comptes\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */
use App\AbstractModules\Controller\AbstractSendController;
use App\Modules\Comptes\Model\Model;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SendController extends AbstractSendController {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        $this->setModel(new Model($this->getContainer()->get("pathModel")));
        parent::process($request, $handler);
        return $this->send_data("show_item", $this->getNamesRoute()->files());
    }

    public function send_data(string $view_show, string $routeFile = ""): ResponseInterface {

        if ($this->is_Erreur()) {
            return $this->getResponse()->withStatus(404);
        }
        $request = $this->getRequest();



        /// save les id_fichier et gere input file (id_file)
        if ($routeFile != "") {
            $file_Upload = $this->getFile_Upload();
            $nameController = $this->getNameController();
            $request = $file_Upload->save($routeFile, $request, $nameController);
        }


        $insert = $request->getParsedBody();

        $id_parent = $this->getModel()->setData($insert);


        /// is new compte danc set data default autorisation$modul
        if (!isset($insert['id']) || $insert['id'] == "") {
            foreach ($this->application as $nameModul => $namecontrollers) {
                $table = 'autorisation$' . $nameModul;
                $this->chargeModel($table);
                $compte = ["comptes" => $id_parent];
                foreach ($namecontrollers as $namecontroller) {
                    $d = array_merge($namecontroller, $compte);
                    $this->getModel()->insert_table_Relation($d);
                }
            }
        }


        $this->chargeModel("comptes");
        //var_dump($id_parent);die();

        $intent = $this->getModel()->show_styleForm($id_parent);

        return $this->render($view_show, ["intent" => $intent]);
    }

}
