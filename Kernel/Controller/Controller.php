<?php

namespace Kernel\Controller;

use Kernel\AWA_Interface\InterfaceFile_Upload;
use Kernel\AWA_Interface\InterfaceRenderer;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\html\File_Upload;
use Kernel\Model\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use function array_merge;

abstract class Controller implements MiddlewareInterface {

    private $model;
    private $File_Upload;
    private $renderer;
    private $controller;
    private $router;
    private $page;
    private $nameController;
    private $request;
    private $response;
    private $InfoTemplete = [];

    function __construct(ContainerInterface $container, string $nameController) {
        $this->nameController = $nameController;

        $this->router = $container->get(RouterInterface::class);
        $this->renderer = $container->get(InterfaceRenderer::class);
        $this->File_Upload = $container->get(InterfaceFile_Upload::class);
    }

    public function process(ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface {

        $this->setRequest($request);
        $this->setResponse($handler->handle($request));
        
        $route = $this->getRouter()->match($this->getRequest());
        $this->setPage($route->getParam($this->getNameController()));
        return $this->getResponse();
        }

    
    
    
    
    function getInfoTemplete() {
        return $this->InfoTemplete;
    }

    function setInfoTemplete(array $InfoTemplete) {

        $this->InfoTemplete = array_merge($this->InfoTemplete, $InfoTemplete);
        return $this->InfoTemplete;
    }

    public function render($view, array $data = []): ResponseInterface {
        
       
        
        $this->renderer->addGlobal("_page", $this->getPage());

        $result = $this->setInfoTemplete($data);

        $render = $this->renderer->render($view, $result);

        $this->response->getBody()->write($render);
        return $this->response;
    }

    function getNameController() {
        return $this->nameController;
    }

    function setNameController($nameController) {
        $this->nameController = $nameController;
    }

    function getModel(): Model {

        return $this->model;
    }

    function getFile_Upload(): File_Upload {
        return $this->File_Upload;
    }

    function getRenderer(): InterfaceRenderer {
        return $this->renderer;
    }

    function getController() {
        return $this->controller;
    }

    function getRouter(): RouterInterface {
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

    function setRouter(RouterInterface $router) {
        $this->router = $router;
    }

    function setPage(string $page) {
        $this->page = $page;
    }

    function setRequest(RequestInterface $request) {
        $this->request = $request;
    }

    function setResponse(ResponseInterface $response) {
        $this->response = $response;
    }

}
