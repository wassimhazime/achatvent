<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\AbstractModules\Controller;

use Kernel\Tools\Tools;
use Psr\Http\Message\ResponseInterface;

/**
 * Description of AjaxController
 *
 * @author wassime
 */
abstract class AbstractAjaxController extends AbstractController
{

    public function ajax_js() : ResponseInterface
    {
      if ($this->is_Erreur()) {
            return $this->getResponse()
                            ->withStatus(404)
                            ->withHeader('Content-Type', 'application/json; charset=utf-8');
        }
        $query = $this->getRequest()->getQueryParams();

        $modeshow = $this->getModeShow($query);
        $modeSelect = $modeshow["modeSelect"];

        $data = $this->getModel()->showAjax($modeSelect, true);
        $json = Tools::json_js($data);
        $this->getResponse()->getBody()->write($json);
        return $this->getResponse()->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
