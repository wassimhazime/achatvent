<?php

use App\Modules\Comptable\Model\Model;
use Kernel\AWA_Interface\InterfaceRenderer;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\AWA_Interface\InterfaceFile_Upload;
use Psr\Container\ContainerInterface;

return [
    "pathModules" => function (ContainerInterface $container): string {

        return ROOT . "App" . D_S . "Modules" . D_S;
    },
    "pathModel" => function (ContainerInterface $container): string {

        return ROOT . "Config/model/";
    },
    InterfaceRenderer::class => function (ContainerInterface $container): InterfaceRenderer {
        //// configue Extension 
        $configueExtension = ROOT . "Config/html/";
        //// default Templte
        $defaultTemplte = ROOT . "App/TEMPLETE";
        $renderer = new \Kernel\Renderer\TwigRenderer($defaultTemplte, $configueExtension);
        // add templet abstract
        $pathAbstractModules = ROOT . "App" . D_S . "AbstractModules" . D_S . "views";
        $renderer->addPath($pathAbstractModules, "AbstractModules");
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
