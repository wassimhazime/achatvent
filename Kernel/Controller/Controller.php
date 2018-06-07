<?php

namespace Kernel\Controller;

use Kernel\html\File_Upload;
use Kernel\Renderer\TwigRenderer;
use Kernel\Router\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Controller {

    protected $model;
    protected $File_Upload;
    protected $renderer;
    protected $controller;
    protected $router;
    protected $page;
    protected $request;
    protected $response;
    private $InfoTemplete = [];

    function getInfoTemplete() {
        return $this->InfoTemplete;
    }

    function setInfoTemplete(array $InfoTemplete) {

        $this->InfoTemplete = array_merge($this->InfoTemplete, $InfoTemplete);
        return $this->InfoTemplete;
    }

    function __construct(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container, string $page) {

        $this->router = $container->get(Router::class);
        $this->renderer = $container->get(TwigRenderer::class);
        $this->File_Upload = $container->get(File_Upload::class);
        $this->request = $request;
        $this->response = $response;


        $route = $this->router->match($request);
        $params = $route->getParams();
        $this->page = $params[$page];
        $this->renderer->addGlobal("_page", $this->page);
    }

    abstract function exec(): ResponseInterface;

    public function render($view, array $data = []): ResponseInterface {


        $result = $this->setInfoTemplete($data);

        $render = $this->renderer->render($view, $result);

        $this->response->getBody()->write($render);
        return $this->response;
    }
    function getModel(): \Kernel\Model\Model {
        return $this->model;
    }

    function getFile_Upload() {
        return $this->File_Upload;
    }

    function getRenderer() {
        return $this->renderer;
    }

    function getController() {
        return $this->controller;
    }

    function getRouter() {
        return $this->router;
    }

    function getPage() {
        return $this->page;
    }

    function getRequest() {
        return $this->request;
    }

    function getResponse() {
        return $this->response;
    }


}
