<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Authentification\Login\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */
use App\Authentification\Login\Model\Model;
use App\AbstractModules\Controller\AbstractController;
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
        $this->chargeModel("comptes");
        $model = $this->getModel();

        $_SESSION["aut"] = ($model->select(["login" => $login, "password" => $password]));
        $r = new \GuzzleHttp\Psr7\Response();
        if (isset($_SESSION["aut"]) && !empty($_SESSION["aut"])) {

            return $r->withHeader("Location", "/")->withStatus(403);
        } else {

            return $r->withHeader("Location", "/Login/login")->withStatus(403);
        }
    }

}
