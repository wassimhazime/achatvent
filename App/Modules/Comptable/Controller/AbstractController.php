<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author wassime
 */

namespace App\Modules\Comptable\Controller;

use App\Modules\Comptable\Model\Model;
use Kernel\Controller\Controller;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractController extends Controller {

    function __construct(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container, string $page) {
        parent::__construct($request, $response, $container, $page);
        $this->model = new Model($container->get( "pathModel"));


        $this->renderer->addGlobal("_URLaction", $this->generateUriAction());
    }

    public function generateUriAction() {
        return ["_ajouter" => $this->generateUri("traitement", $this->page, "ajouter")];
    }

    public function generateUri($nomroute, $controle, $action = "voir", $id = 0) {
        return $this->router->generateUri($nomroute, ["controle" => $controle,
                    "action" => $action,
                    "id" => $id
        ]);
    }

}
