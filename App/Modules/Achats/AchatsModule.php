<?php

namespace App\Modules\Achats;

use Kernel\AWA_Interface\RouterInterface;
use App\AbstractModules\AbstractModule;
use Kernel\AWA_Interface\RendererInterface;
use App\Modules\Achats\{
    Controller\SendController,
    Controller\ShowController,
    Controller\AjaxController,
    Controller\FileController
};

class AchatsModule extends AbstractModule {

    public function addPathRenderer(RendererInterface $renderer) {
        $pathModule = __DIR__ . D_S . "views" . D_S;
        $renderer->addPath($pathModule, self::NameModule);
    }

    const Controllers = [
        'commandes',
        'bons$achats',
        'factures$achats',
        'avoirs$achats'
    ];
    const NameModule = "Achats";
    const IconModule = " fa fa-fw fa-shopping-cart ";

    public function addRoute(RouterInterface $router, array $middlewares) {

        $nameRoute = $this->getNamesRoute();
        $Options = ["container" => $this->getContainer(),
            "namesControllers" => self::Controllers,
            "nameModule" => self::NameModule,
            "middlewares" => $middlewares,
            "nameRoute" => $nameRoute
        ];


        $router->addRoute_get(
                "/{controle:[a-z\$]+}[/{action:[a-z]+}-{id:[0-9\,]+}]", new ShowController($Options), $nameRoute->show(), self::NameModule
        );


        $router->addRoute_post(
                "/{controle:[a-z\$]+}/{action:[a-z]+}-{id:[0-9]+}", new SendController($Options), $nameRoute->send(), self::NameModule
        );


        $router->addRoute_get(
                "/ajax/{controle:[a-z\$]+}", new AjaxController($Options), $nameRoute->ajax(), self::NameModule
        );


        $router->addRoute_get(
                "/files/{controle:[a-z0-9\_\$\-]+}", new FileController($Options), $nameRoute->files(), self::NameModule
        );
    }

}
