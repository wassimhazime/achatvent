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

namespace App\Modules\Statistique\Controller;

use App\Modules\Comptable\Model\Model;
use Kernel\html\File_Upload;
use Kernel\Renderer\TwigRenderer;
use Kernel\Router\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractController
{

    protected $model;
    protected $File_Upload;
    protected $renderer;
    protected $controller;
    protected $router;
    protected $page;
    protected $request;
    protected $response;

    function __construct(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container, string $page)
    {

        $this->router = $container->get(Router::class);
        $this->model = $container->get(Model::class);
        $this->renderer = $container->get(TwigRenderer::class);
        $this->File_Upload = $container->get(File_Upload::class);

        $this->request = $request;
        $this->response = $response;

        $route = $this->router->match($request);
        $params = $route->getParams();
        $this->page = $params[$page];
    }

    abstract function exec(): ResponseInterface;

    public function render($view, array $data = []): ResponseInterface
    {
        $this->renderer->addGlobal("router", $this->router);
        $this->renderer->addGlobal("page", $this->page);

        $result = array_merge($data, $this->getInfoTemplete());

        $render = $this->renderer->render($view, $result);

        $this->response->getBody()->write($render);
        return $this->response;
    }

    private function getInfoTemplete(): array
    {
        $pages = $this->model->getAllTables();

        $_tableDataBase = ["_tableDataBase" => $this->generateUriDatabase([
                "_achats" => ['commandes', 'bons$achats', 'avoirs$achats', 'factures$achats', "achats"],
                "_entreprise" => ["clients", 'raison$sociale', 'contacts', 'mode$paiement'],
                "_ventes" => ['devis', 'factures$ventes', 'ventes']
        ])];

        $_menu = ["_menu" => [
                "_page" => $this->page,
                "_login" => [],
                "_rapports" => [],
                "_recherche" => [],
                "_statistique" => [],
                "_transactions" => [],
                "_tva" => []
            ]
        ];
        $_page = ["_page" => [
                "_nom" => $this->page
            ]
        ];
        $_URLaction = ["_URLaction" => $this->generateUriAction()];

        return array_merge($_tableDataBase, $_menu, $_URLaction, $_page);
    }

    private function generateUriDatabase(array $info): array
    {

        $infogenerate = [];
        foreach ($info as $key => $group) {
            foreach ($group as $item) {
                $label = str_replace("$", "  ", $item);
                $infogenerate[$key][] = [$label => $this->generateUri("actionGET", $item)];
            }
        }

        return $infogenerate;
    }

    private function generateUriAction()
    {
        return ["_ajouter" => $this->generateUri("traitement", $this->page, "ajouter")];
    }

    private function generateUri($nomroute, $controle, $action = "voir", $id = 0)
    {
        return $this->router->generateUri($nomroute, ["controle" => $controle,
                    "action" => $action,
                    "id" => $id
        ]);
    }
}
