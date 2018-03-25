<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Module
 *
 * @author wassime
 */

namespace App\Modules\Achat;

use Kernel\html\FactoryTAG;
use Kernel\INTENT\Intent;
use Kernel\Model\Model;
use Kernel\Renderer\TwigRenderer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Module {

    public $model;
    public $FactoryTAG;
    public $File_Upload;
    public $renderer;

    public function addPathRenderer($renderer, $pathModules) {
        $renderer->addPath($pathModules . "Achat" . D_S . "views", "achat");
    }

    public function addRoute($router) {

        // $router->get("/{controle:[a-z]+}", [$this, "MVC"], "blog.strj");
        $router->get("/achat/{controle:[a-z\_]+}", [$this, "MVC"], "achat.get");
        $router->get("/{controle:[a-z\_]*}", [$this, "MVC"], "achat");

        $router->post("/achat/{controle:[a-z\_]+}", [$this, "POST"], "post.post");
        $router->post("/{controle:[a-z\_]*}", [$this, "POST"], "post");
    }

    public function __construct(ContainerInterface $container) {

        $this->model = $container->get(Model::class);
        $this->FactoryTAG = $container->get(FactoryTAG::class);
        $this->renderer = $container->get(TwigRenderer::class);
        $this->File_Upload=new \Kernel\html\File_Upload();
    }

    public function MVC(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container, $params) {

        $page = $params["controle"];
       if($page=="" or $page=="index" ){    
            $response->getBody()->write("menu");
        return $response;
           
       }
        $query = $request->getQueryParams();

        $this->model->setStatement($page);



        if (isset($query["supprimer"])) {
            return $this->supprimer($query, $request, $response);
        } elseif (isset($query["modifier"])) {
            return $this->modifier($page, $query, $request, $response);
        } elseif (isset($query["ajouter"])) {
            return $this->ajouter($query, $response);
        } elseif (isset($query["imageview"])) {
            $id_image = $query["imageview"];
            return $this->File_Upload->get($id_image);
        } else {
            return $this->show($response);
        }
    }

    public function POST(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container, $params) {
        $page = $params["controle"];
        $this->File_Upload->setPreffix($page);
        $insert = $this->File_Upload->set($request);
        $this->model->setStatement($page);
        $msg = $this->model->setData($insert);
        $msghtml = $this->FactoryTAG->message($msg);  //twig
        $data = $this->renderer->render("@achat/message_ajouter", ["message" => $msghtml]);
        $response->getBody()->write($data);
        return $response;
    }

    //////////////////////////////////////////////////////////////////////
    public function supprimer($query, $request, $response) {
        $conditon = ['id' => $query['id']];
        $this->model->delete($conditon);
        $url = $request->getUri()->getPath();
        return $response->withStatus(301)->withHeader('Location', $url);
    }

    public function modifier($page, $query, $request, $response) {

        $conditon = ["$page.id" => $query['id']];
        $intentform = $this->model->formDefault(Intent::MODE_FORM, $conditon);
        $form = $this->FactoryTAG->FormHTML($intentform);  //twig

        $data = $this->renderer->render("@achat/add", ["form" => $form, "table" => '$table']);
        $response->getBody()->write($data);
        return $response;
    }

    public function ajouter($query, $response) {
        if ($query["ajouter"] != "Valider") {
            $intentformselect = $this->model->formSelect(Intent::MODE_FORM);
            if (!empty($intentformselect->getEntitysSchema()->getFOREIGN_KEY())) {
                $form = $this->FactoryTAG->FormHTML($intentformselect);  //twig
                $data = $this->renderer->render("@achat/select", ["form" => $form]);
                $response->getBody()->write($data);
                return $response;
            }
        }
        unset($query["ajouter"]);


        $intentform = $this->model->form(Intent::MODE_FORM, $query);
        $form = $this->FactoryTAG->FormHTML($intentform);  //twig
        $data = $this->renderer->render("@achat/add", ["form" => $form]);
        $response->getBody()->write($data);
        return $response;
    }

    public function show($response) {
        $intentshow = $this->model->show(Intent::MODE_SELECT_ALL_ALL, true);

        $table = $this->FactoryTAG->tableHTML($intentshow); //twig

        $data = $this->renderer->render("@achat/facture", ["table" => $table]);
        $response->getBody()->write($data);
        return $response;
    }
    

   

}
