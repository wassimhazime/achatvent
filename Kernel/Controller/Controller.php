<?php

namespace Kernel\Controller;

use Kernel\AWA_Interface\File_UploadInterface;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\html\File_Upload;
use Kernel\Model\Model;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function array_merge;

abstract class Controller implements MiddlewareInterface
{

    private $erreur = [];
    private $container;
    private $model;
    private $File_Upload;
    private $renderer;
    private $router;
    private $request;
    private $response;
    private $InfoTemplete = [];
    private $middlewares = [];
    private $nameController = "";
    private $namesControllers = [];

    function __construct(ContainerInterface $container, array $namesControllers)
    {

        $this->container = $container;
        $this->namesControllers = $namesControllers;
        $this->erreur["Controller"] = false;
        $this->erreur["Model"] = false;

        $this->router = $container->get(RouterInterface::class);
        $this->renderer = $container->get(RendererInterface::class);
        $this->File_Upload = $container->get(File_UploadInterface::class);
    }

    function setMiddlewares(array $middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

//        foreach ($this->middlewares as $middleware) {
//            $this->container->get(RequestHandlerInterface::class)
//                    ->pipe($middleware);
//        }
        

        $this->setRequest($request);
        $this->setResponse($handler->handle($request));

        $route = $this->getRouter()->match($this->getRequest());
        
        $this->setNameController($route->getParam("controle"));
        $this->chargeModel($this->getNameController());

        return $this->getResponse();
    }

    public function render($view, array $data = []): ResponseInterface
    {



        $this->renderer->addGlobal("_page", $this->getNameController());

        $result = $this->setInfoTemplete($data);

        $render = $this->renderer->render($view, $result);

        $response = $this->getResponse();
        $response->getBody()->write($render);


        return $response;
    }

    function getInfoTemplete()
    {
        return $this->InfoTemplete;
    }

    function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    function setInfoTemplete(array $InfoTemplete)
    {

        $this->InfoTemplete = array_merge($this->InfoTemplete, $InfoTemplete);
        return $this->InfoTemplete;
    }

    function getNameController(): string
    {
        return $this->nameController;
    }

    function setNameController(string $nameController): bool
    {
        $flag = in_array($nameController, $this->getNamesControllers());
        if ($flag) {
            $this->nameController = $nameController;
        }
        $this->erreur["Controller"] = $flag;
        return $flag;
    }

    protected function getModel(): Model
    {

        return $this->model;
    }

    protected function chargeModel($table): bool
    {
        $flag = $this->getModel()->setTable($table);
        $this->erreur["Model"] = $flag;
        return $flag;
    }

    function getFile_Upload(): File_Upload
    {
        return $this->File_Upload;
    }

    function getRenderer(): InterfaceRenderer
    {
        return $this->renderer;
    }

//    function getController() {
//        return $this->controller;
//    }

    function getRouter(): RouterInterface
    {
        return $this->router;
    }

    function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    function is_Erreur(string $MC = ""): bool
    {
        if ($MC=="") {
            return !$this->erreur["Controller"] || !$this->erreur["Model"];
        } else {
            return !$this->erreur[$MC];
        }
    }

    function setModel($model)
    {
        $this->model = $model;
    }

    function getNamesControllers(): array
    {
        return $this->namesControllers;
    }

    function setFile_Upload($File_Upload)
    {
        $this->File_Upload = $File_Upload;
    }

    function setRenderer($renderer)
    {
        $this->renderer = $renderer;
    }

//    function setController($controller) {
//        $this->controller = $controller;
//    }

    function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }

    function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }
}
