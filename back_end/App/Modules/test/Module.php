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

namespace App\Modules\test;

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

    public function addPathRenderer($renderer,$pathModules)
    {
        $renderer->addPath($pathModules."test" . D_S ."views", "test");
    }

    public function addRoute($router)
    {
        $router->get("/test1/{controle:[a-z]+}", [$this, "MVC"], "test.strj");
        $router->get("/test/{controle:[a-z]+}", [$this, "MVC"], "test.str");
    }

    public function __construct(ContainerInterface $container)
    {

        $this->model = $container->get(Model::class);
        $this->FactoryTAG = $container->get(FactoryTAG::class);
        $this->renderer = $container->get(TwigRenderer::class);
    }

    public function MVC(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container, $params)
    {
        $this->model->setStatement($params["controle"]);
        $intentshow = $this->model->show(Intent::MODE_SELECT_ALL_ALL, 1);
        $table = $this->FactoryTAG->tableHTML($intentshow);

        $intentform = $this->model->form(Intent::MODE_FORM);

        $form = $this->FactoryTAG->FormHTML($intentform);
        $data = $this->renderer->render("@test/facture", ["form" => $form, "table" => $table]);

        $response->getBody()->write($data);
        return $response;
    }
}
