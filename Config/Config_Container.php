<?php

use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\AWA_Interface\File_UploadInterface;
use Kernel\AWA_Interface\ModelInterface;
use Kernel\AWA_Interface\ActionInterface;
use Kernel\AWA_Interface\NamesRouteInterface;
use Kernel\AWA_Interface\EventManagerInterface;

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
    ModelInterface::class => function (ContainerInterface $container): ModelInterface {
        return new \Kernel\Model\Model($container->get("pathModel"));
    }, ActionInterface::class => function (ContainerInterface $container): ActionInterface {
        return new Kernel\Controller\Action();
    }, NamesRouteInterface::class => function (ContainerInterface $container): NamesRouteInterface {
        return new Kernel\Controller\NamesRoute();
    },
    "configue_Extension" => function (ContainerInterface $container): string {
        return $container->get("Config") . "html" . D_S;
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
    RendererInterface::class => function (ContainerInterface $container): RendererInterface {

        $renderer = new \Kernel\Renderer\TwigRenderer(
                $container->get("default_Templte"), $container->get("configue_Extension")
        );
        // add templet abstract
        $renderer->addPath($container->get("AbstractTempletModules"), "AbstractModules");
        return $renderer;
    }
    ,
    RouterInterface::class => function (ContainerInterface $container): RouterInterface {
        return new \Kernel\Router\Router;
    },
    File_UploadInterface::class => function (ContainerInterface $container): File_UploadInterface {
        return new \Kernel\html\File_Upload($container->get(RouterInterface::class),  "filesUpload/");
    },
  EventManagerInterface::class => function (ContainerInterface $container): EventManagerInterface {
        return new Kernel\Event\EventManager() ;
    },
];
