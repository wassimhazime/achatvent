<?php

use App\Modules\Comptable\Model\Model;
use Kernel\html\File_Upload;
use Kernel\Renderer\TwigRenderer;
use Kernel\Router\Router;
use Psr\Container\ContainerInterface;

return [
    "pathModules" => function (ContainerInterface $container): string {

        return ROOT . "App" . D_S . "Modules" . D_S;
    },
    "pathModel" => function (ContainerInterface $container): string {

        return ROOT . "Config/model/" ;
    },
    TwigRenderer::class => function (ContainerInterface $container): TwigRenderer {
       //// configue Extension 
        $configueExtension=ROOT . "Config/html/";
        //// default Templte
        $defaultTemplte=ROOT . "App/TEMPLETE";
        $renderer= new TwigRenderer($defaultTemplte,$configueExtension );
       
        
        // add templet abstract
        $pathAbstractModules = ROOT . "App" . D_S . "AbstractModules" . D_S."views";
        $renderer->addPath($pathAbstractModules, "AbstractModules");
        return $renderer;
    },
    Model::class => function (ContainerInterface $container): Model {

        return new Model($container->get( "pathModel"));
    },
    Router::class => function (ContainerInterface $container): Router {
        return new Router;
    },
    File_Upload::class => function (ContainerInterface $container): File_Upload {
        return new File_Upload($container->get(Router::class),"public/filesUpload/");
    },
];
