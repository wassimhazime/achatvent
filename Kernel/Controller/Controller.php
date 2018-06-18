<?php

namespace Kernel\Controller;

use Kernel\html\File_Upload;
use Kernel\Renderer\TwigRenderer;
use Kernel\Router\Router;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class Controller {

    private $model;
    private $File_Upload;
    private $renderer;
    private $controller;
    private $router;
    private $page;
    private $request;
    private $response;
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
    
    public function ajax_js() : ResponseInterface{
             $this->getModel()->setStatement($this->getPage());
        $query = $this->getRequest()->getQueryParams();

        $modeshow = $this->getModeShow($query);
        $modeintent = $modeshow["modeIntent"];

        $data = $this->getModel()->showAjax($modeintent, true);
        $json = \Kernel\Tools\Tools::json_js($data);
        $this->getResponse()->getBody()->write($json);
        return $this->getResponse()->withHeader('Content-Type', 'application/json; charset=utf-8');
     
    }

    public function render($view, array $data = []): ResponseInterface {


        $result = $this->setInfoTemplete($data);

        $render = $this->renderer->render($view, $result);

        $this->response->getBody()->write($render);
        return $this->response;
    }

    function getModel(): \Kernel\Model\Model {
        return $this->model;
    }

    function getFile_Upload(): File_Upload {
        return $this->File_Upload;
    }

    function getRenderer(): TwigRenderer {
        return $this->renderer;
    }

    function getController() {
        return $this->controller;
    }

    function getRouter(): Router {
        return $this->router;
    }

    function getPage(): string {
        return $this->page;
    }

    function getRequest(): ServerRequestInterface {
        return $this->request;
    }

    function getResponse(): ResponseInterface {
        return $this->response;
    }

    function setModel($model) {
        $this->model = $model;
    }

    function setFile_Upload($File_Upload) {
        $this->File_Upload = $File_Upload;
    }

    function setRenderer($renderer) {
        $this->renderer = $renderer;
    }

    function setController($controller) {
        $this->controller = $controller;
    }

    function setRouter($router) {
        $this->router = $router;
    }

    function setPage($page) {
        $this->page = $page;
    }

    function setRequest($request) {
        $this->request = $request;
    }

    function setResponse($response) {
        $this->response = $response;
    }

}
