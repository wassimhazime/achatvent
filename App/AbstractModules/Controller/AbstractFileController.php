<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\AbstractModules\Controller;

use Psr\Http\Message\ResponseInterface;

/**
 * Description of FileController
 *
 * @author wassime
 */
abstract class AbstractFileController extends AbstractController {

    public function get_views_files(string $name_views): ResponseInterface {
        if ($this->is_Erreur("Controller")) {
            return $this->getResponse()->withStatus(404);
        }
        $files = $this->getFile_Upload()->get($this->getRoute()->getParam("controle"));

        return $this->render($name_views, ["files" => $files]);
    }

}
