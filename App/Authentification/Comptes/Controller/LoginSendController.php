<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Authentification\Comptes\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */

use App\AbstractModules\Controller\AbstractController;
use App\Authentification\AutorisationInterface;
use App\Authentification\Comptes\Model\Model;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginSendController extends AbstractController {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        parent::process($request, $handler);
        $password = false;
        $login = false;
        $post = $request->getParsedBody();
        if (isset($post["login"]) && !empty($post["login"])) {
            $login = $post["login"];
        }
        if (isset($post["password"]) && !empty($post["password"])) {
            $password = $post["password"];
        }
        if ($login || $password) {
            
        }


        $this->setModel(new Model($this->getContainer()->get("pathModel")));
        $model = $this->getModel("comptes");
        $compte = $model->login($login, $password);

        $session = $this->getSession();
        $response = $this->getResponse();
        $key=AutorisationInterface::Name_Key_Session;



        $session->set($key, $compte);


        if ($session->has($key)) {
            return $response->withHeader("Location", "/")->withStatus(301);
        } else {
            $url = $this->getRouter()->generateUri("login");

            return $response->withHeader("Location", $url)->withStatus(403);
        }
    }

}
