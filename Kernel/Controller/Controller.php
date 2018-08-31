<?php

namespace Kernel\Controller;

use Kernel\AWA_Interface\ActionInterface;
use Kernel\AWA_Interface\File_UploadInterface;
use Kernel\AWA_Interface\ModelInterface;
use Kernel\AWA_Interface\NamesRouteInterface;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouteInterface;
use Kernel\AWA_Interface\RouterInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function array_merge;
use function in_array;
use function is_a;
use function preg_match;
use function str_replace;
use function ucfirst;

abstract class Controller implements MiddlewareInterface {

    private $erreur = [];
    private $action = [];
    private $container;
    private $model;
    private $File_Upload;
    private $renderer;
    private $router;
    private $route;
    private $request;
    private $response;
    private $data_views = [];
    private $middlewares = [];
    private $nameController = "";
    private $namesControllers = [];
    private $nameModule;
    private $namesRoute;
   
                function __construct(array $Options) {
        $this->container = $Options["container"];
        $this->namesControllers = $Options["namesControllers"];
        $this->nameModule = $Options["nameModule"];
        $this->setMiddlewares($Options["middlewares"]);
        $this->namesRoute = $Options["nameRoute"];
      

        $this->action = $this->getContainer()->get(ActionInterface::class);

        $this->namesRoute->set_NameModule($this->nameModule);
        $this->erreur["Controller"] = false;
        $this->erreur["Model"] = false;

        $this->setRouter($this->getContainer()->get(RouterInterface::class));
        $this->setRenderer($this->getContainer()->get(RendererInterface::class));
        $this->setFile_Upload($this->getContainer()->get(File_UploadInterface::class));
    }

    function getContainer(): ContainerInterface {
        return $this->container;
    }

// psr 7

    function setRequest(ServerRequestInterface $request) {
        $this->request = $request;
    }

    function setResponse(ResponseInterface $response) {
        $this->response = $response;
    }

    function getRequest(): ServerRequestInterface {
        return $this->request;
    }

    function getResponse(): ResponseInterface {
        return $this->response;
    }

// psr 15

    function setMiddlewares(array $middlewares) {
        $this->middlewares = $middlewares;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {

        foreach ($this->middlewares as $middleware) {
            $this->container->get(RequestHandlerInterface::class)
                    ->pipe($middleware);
        }


        $this->setRequest($request);
        $this->setResponse($handler->handle($request));
        $this->setRoute($this->getRouter()->match($this->getRequest()));
        $this->setNameController($this->getRoute()->getParam("controle"));
        $this->chargeModel($this->getNameController());

        return $this->getResponse();
    }

// router

    function setRouter(RouterInterface $router) {
        $this->router = $router;
    }

    function getRoute(): RouteInterface {
        return $this->route;
    }

    function setRoute(RouteInterface $route) {
        $this->route = $route;
    }

    function getRouter(): RouterInterface {
        return $this->router;
    }

    // mvc
    function is_Erreur(string $MC = ""): bool {
        if ($MC == "") {
            return !$this->erreur["Controller"] || !$this->erreur["Model"];
        } else {
            return !$this->erreur[$MC];
        }
    }

    function Actions(): ActionInterface {
        return $this->action;
    }

    function getNameModule(): string {
        return $this->nameModule;
    }

    function getNamesRoute(): NamesRouteInterface {
        return $this->namesRoute;
    }

    /// model
    function setModel(ModelInterface $model) {
        $this->model = $model;
    }

    protected function getModel(): ModelInterface {
        return $this->model;
    }

    protected function hasModel(): bool {
        return is_a($this->model, ModelInterface::class);
    }

    protected function chargeModel($table): bool {
        $flag = $this->hasModel();
        if ($flag) {
            $flag = $this->getModel()->setTable($table);
            $this->erreur["Model"] = $flag;
        }
        return $flag;
    }

    /// controller

    function getNamesControllers(): array {
        return $this->namesControllers;
    }

    function getNameController(): string {
        return $this->nameController;
    }

    function setNameController(string $nameController): bool {
        $flag = false;
        // si on namse du module
        $flag = in_array($nameController, $this->getNamesControllers());
        if ($flag) {
            $this->nameController = $nameController;
        } else {
            // si name controller file
            preg_match('/([a-zA-Z\$]+)_(.+)/i', $nameController, $matches);
            if (!empty($matches)) {
                $flag = in_array($matches[1], $this->getNamesControllers());
                if ($flag) {
                    $this->nameController = $matches[1];
                }
            }
        }
        //etat du erreur
        $this->erreur["Controller"] = $flag;
        return $flag;
    }

    /// view
    function add_data_views(array $data_views): array {

        $this->data_views = array_merge($this->data_views, $data_views);
        return $this->data_views;
    }

    function getFile_Upload(): File_UploadInterface {
        return $this->File_Upload;
    }

    function getRenderer(): RendererInterface {
        return $this->renderer;
    }

    function setFile_Upload(File_UploadInterface $File_Upload) {
        $this->File_Upload = $File_Upload;
    }

    function setRenderer(RendererInterface $renderer) {
        $this->renderer = $renderer;
    }

    public function render($name_view, array $data = []): ResponseInterface {
        $renderer = $this->getRenderer();

        $renderer->addGlobal("_page", ucfirst(str_replace("$", "  ", $this->getNameController())));
        $renderer->addGlobal("_Controller", $this->getNameController());
        $renderer->addGlobal("_Action", $this->Actions());
       
        $renderer->addGlobal("_NamesRoute", $this->getNamesRoute());
        $data_view = $this->add_data_views($data);

        $render = $renderer->render("@{$this->getNameModule()}/" . $name_view, $data_view);

        $response = $this->getResponse();
        $response->getBody()->write($render);
        return $response;
    }

}
