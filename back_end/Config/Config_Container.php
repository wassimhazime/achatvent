<?php

use App\Modules\Comptable\Model\Model;
use Kernel\html\FactoryTAG;
use Kernel\html\File_Upload;
use Kernel\Renderer\TwigRenderer;
use Kernel\Router\Router;
use Psr\Container\ContainerInterface;

return [
    "pathModules" => function (ContainerInterface $container): string {
        return ROOT . "back_end" . D_S . "App" . D_S . "Modules" . D_S;
    },
    TwigRenderer::class => function (ContainerInterface $container): TwigRenderer {
        return new TwigRenderer(ROOT . "back_end/App/TEMPLETE");
    },
    Model::class => function (ContainerInterface $container): Model {

        return new Model(ROOT . "back_end/Config/model/");
    },
    FactoryTAG::class => function (ContainerInterface $container): FactoryTAG {
        return new FactoryTAG(ROOT . "back_end/Config/html/");
    },
    Router::class => function (ContainerInterface $container): Router {
        return new Router;
    },
      File_Upload::class => function (ContainerInterface $container): File_Upload {
        return new File_Upload();
    },
];
