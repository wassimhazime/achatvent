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
        return new TwigRenderer(ROOT . "App/TEMPLETE", ROOT . "Config/html/");
    },
    Model::class => function (ContainerInterface $container): Model {

        return new Model($container->get( "pathModel"));
    },
    Router::class => function (ContainerInterface $container): Router {
        return new Router;
    },
    File_Upload::class => function (ContainerInterface $container): File_Upload {
        return new File_Upload("public/imageUpload/");
    },
];
