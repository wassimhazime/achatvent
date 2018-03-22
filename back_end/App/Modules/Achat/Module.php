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

class Module
{

    public $model;
    public $FactoryTAG;
    public $renderer;

    public function addPathRenderer($renderer, $pathModules)
    {
        $renderer->addPath($pathModules . "Achat" . D_S . "views", "achat");
    }

    public function addRoute($router)
    {

        // $router->get("/{controle:[a-z]+}", [$this, "MVC"], "blog.strj");
        $router->get("/achat/{controle:[a-z\_]+}", [$this, "MVC"], "achat.get");
        $router->get("/{controle:[a-z\_]*}", [$this, "MVC"], "achat");

        $router->post("/achat/{controle:[a-z\_]+}", [$this, "POST"], "post.post");
        $router->post("/{controle:[a-z\_]*}", [$this, "POST"], "post");
    }

    public function __construct(ContainerInterface $container)
    {

        $this->model = $container->get(Model::class);
        $this->FactoryTAG = $container->get(FactoryTAG::class);
        $this->renderer = $container->get(TwigRenderer::class);
    }

    public function MVC(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container, $params)
    {

        $page = $params["controle"];
        $query = $request->getQueryParams();

        $this->model->setStatement($page);



        if (isset($query["supprimer"])) {
            return $this->supprimer($query, $request, $response);
        } elseif (isset($query["modifier"])) {
            return $this->modifier($page, $query, $request, $response);
        } elseif (isset($query["ajouter"])) {
            return $this->ajouter($query, $response);
        } elseif (isset($query["imageview"])) {
            return $this->imageview($query, $request, $response);
        } else {
            return $this->show($response);
        }
    }

    public function POST(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container, $params)
    {
        $insert = $request->getParsedBody();
        
        $page = $params["controle"];


        $insert = $this->setImage($request, $page, $insert);

        $this->model->setStatement($page);
        if ($insert['id']=="") {
             $msg = $this->model->setData($insert, Intent::MODE_INSERT);
        } else {
             $msg = $this->model->setData($insert, Intent::MODE_UPDATE);
        }
       
        
        $msghtml = $this->FactoryTAG->message($msg);  //twig
        $data = $this->renderer->render("@achat/message_ajouter", ["message" => $msghtml]);
        $response->getBody()->write($data);
        return $response;
    }

    //////////////////////////////////////////////////////////////////////
    public function supprimer($query, $request, $response)
    {
        $conditon = ['id' => $query['id']];
        $this->model->delete($conditon);
        $url = $request->getUri()->getPath();
        return $response->withStatus(301)->withHeader('Location', $url);
    }

    public function modifier($page, $query, $request, $response)
    {
        //  $oldData = $this->model->show(Intent::MODE_SELECT_ALL_ALL, $conditon);
        //  $table = $this->FactoryTAG->tableHTML($oldData); //twig
        $conditon = ["$page.id" => $query['id']];
        $intentform = $this->model->formDefault(Intent::MODE_FORM, $conditon);
        $form = $this->FactoryTAG->FormHTML($intentform);  //twig

        $data = $this->renderer->render("@achat/add", ["form" => $form, "table" => '$table']);
        $response->getBody()->write($data);
        return $response;
    }

    public function ajouter($query, $response)
    {
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

    public function imageview($query, $request, $response)
    {
        $id_image = $query["imageview"];
        $dir = ROOT . "public/imageUpload/";
        $dir = "imageUpload/";
        $images = [];
        foreach (scandir($dir) as $image) {
            $subject = $image;
            $pattern = '/^' . $id_image . '/';

            if (preg_match($pattern, $subject)) {
                $images[] = $dir . $image;
            }
        }
        foreach ($images as $image) {
            echo '<img src="' . $image . '" alt="Girl in a jacket" style="width:800px;"> <br>';
        }

        die();
    }

    public function setImage($request, $page, $insert)
    {
        $fils = $request->getUploadedFiles();
        if (isset($fils["image"])) {
            $images = $fils["image"];
            $flage = ($images[0]);

            if ($flage->getClientFilename() != '') {
                $id_image = $page . "_" . date("Y-m-d-H-i-s");

                foreach ($images as $f) {
                    if (!$f->getClientFilename() == "") {
                        $f->moveTo("imageUpload/" . $id_image . "_" . $f->getClientFilename());
                    }
                }
                $insert["image"] = "id_image=>" . $id_image;
            }
        }
        return $insert;
    }

    public function show($response)
    {
        $intentshow = $this->model->show(Intent::MODE_SELECT_ALL_ALL, true);

        $table = $this->FactoryTAG->tableHTML($intentshow); //twig

        $data = $this->renderer->render("@achat/facture", ["table" => $table]);
        $response->getBody()->write($data);
        return $response;
    }
}
