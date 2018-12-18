<?php

namespace App\Modules\Ventes;

use Kernel\AWA_Interface\RouterInterface;
use App\AbstractModules\AbstractModule;
use Kernel\AWA_Interface\RendererInterface;
use App\Modules\Ventes\Controller\SendController;
use App\Modules\Ventes\Controller\ShowController;
use App\Modules\Ventes\Controller\AjaxController;
use App\Modules\Ventes\Controller\FileController;

class VentesModule extends AbstractModule
{

    protected $Controllers = [
        'devis',
        'factures$ventes'
    ];

    const NameModule = "Ventes";
    const IconModule = " fa fa-fw fa-usd   ";

    public function addPathRenderer(RendererInterface $renderer)
    {
        $pathModule = __DIR__ . D_S . "views" . D_S;
        $renderer->addPath($pathModule, self::NameModule);
    }

    public function addRoute(RouterInterface $router)
    {
        $nameRoute = $this->getNamesRoute();

        $Options = ["container" => $this->getContainer(),
            "namesControllers" => $this->Controllers,
            "nameModule" => self::NameModule,
            "middlewares" => $this->middlewares,
            "nameRoute" => $nameRoute
        ];


        $router->addRoute_get(
            "/{controle:[a-z\$]+}[/{action:[a-z]+}-{id:[0-9\,]+}]",
            new ShowController($Options),
            $nameRoute->show(),
            self::NameModule
        );


        $router->addRoute_post(
            "/{controle:[a-z\$]+}/{action:[a-z]+}-{id:[0-9]+}",
            new SendController($Options),
            $nameRoute->send(),
            self::NameModule
        );


        $router->addRoute_get(
            "/ajax/{controle:[a-z\$]+}",
            new AjaxController($Options),
            $nameRoute->ajax(),
            self::NameModule
        );


        $router->addRoute_get(
            "/files/{controle:[a-z0-9\_\$\-]+}",
            new FileController($Options),
            $nameRoute->files(),
            self::NameModule
        );
    }
}
