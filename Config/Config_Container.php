<?php

use App\Modules\Comptable\Model\Model;
use Kernel\AWA_Interface\InterfaceRenderer;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\AWA_Interface\InterfaceFile_Upload;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

return [
    "Config" => function (): string {
        return ROOT . "Config" . D_S;
    }, "App" => function (): string {
        return ROOT . "App" . D_S;
    },
    "pathModel" => function (ContainerInterface $container): string {
        return $container->get("Config") . "model" . D_S;
    },
    "configue_Extension" => function (ContainerInterface $container): string {
        return $container->get("Config") . "html" . D_S;
    }, "pathModules" => function (ContainerInterface $container): string {
        return $container->get("App") . "Modules" . D_S;
    },
    "default_Templte" => function (ContainerInterface $container): string {
        return $container->get("App") . "TEMPLETE";
    },
    "AbstractTempletModules" => function (ContainerInterface $container): string {
        return $container->get("App") . "AbstractModules" . D_S . "views";
    }
    ,
    ResponseInterface::class => function (): ResponseInterface {
        return new \GuzzleHttp\Psr7\Response();
    },
    ServerRequestInterface::class => function (): ServerRequestInterface {
        return \GuzzleHttp\Psr7\ServerRequest::fromGlobals();
    },
    RequestHandlerInterface::class => function (ContainerInterface $container): RequestHandlerInterface {
        return new \Kernel\Middleware\Despatcher($container->get(ResponseInterface::class));
    },
    InterfaceRenderer::class => function (ContainerInterface $container): InterfaceRenderer {

        $renderer = new \Kernel\Renderer\TwigRenderer(
                $container->get("default_Templte"), $container->get("configue_Extension")
        );
        // add templet abstract
        $renderer->addPath($container->get("AbstractTempletModules"), "AbstractModules");
        return $renderer;
    },
    Model::class => function (ContainerInterface $container): Model {
        return new Model($container->get("pathModel"));
    },
    RouterInterface::class => function (ContainerInterface $container): RouterInterface {
        return new \Kernel\Router\Router;
    },
    InterfaceFile_Upload::class => function (ContainerInterface $container): InterfaceFile_Upload {
        return new \Kernel\html\File_Upload($container->get(RouterInterface::class), "public/filesUpload/");
    },
];
