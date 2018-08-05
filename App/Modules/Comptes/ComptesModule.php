<?php

namespace App\Modules\Comptes;

use Kernel\AWA_Interface\RouterInterface;
use App\AbstractModules\AbstractModule;
use Kernel\AWA_Interface\RendererInterface;
use App\Modules\Comptes\{
    Controller\SendController,
    Controller\ShowController,
    Controller\AjaxController,
    Controller\FileController
};

class ComptesModule extends AbstractModule {

    protected $Controllers = [
        "comptes"];

    const NameModule = "Comptes";
    const IconModule = " fa fa-fw fa-stack-overflow ";

    public function addPathRenderer(RendererInterface $renderer) {
        $pathModule = __DIR__ . D_S . "views" . D_S;
        $renderer->addPath($pathModule, self::NameModule);
    }

    public function addRoute(RouterInterface $router, array $middlewares) {
        $nameRoute = $this->getNamesRoute();
        $this->Controllers = array_merge($this->Controllers, $this->autorisation_name);

        
        
        $Options = ["container" => $this->getContainer(),
            "namesControllers" => $this->Controllers,
            "nameModule" => self::NameModule,
            "middlewares" => $middlewares,
            "nameRoute" => $nameRoute,
            "application"=> $this->application
        ];


        $router->addRoute_get(
                "/{controle:[a-zA-Z\$]+}[/{action:[a-z]+}-{id:[0-9\,]+}]", new ShowController($Options), $nameRoute->show(), self::NameModule
        );


        $router->addRoute_post(
                "/{controle:[a-zA-Z\$]+}/{action:[a-z]+}-{id:[0-9]+}", new SendController($Options), $nameRoute->send(), self::NameModule
        );


        $router->addRoute_get(
                "/ajax/{controle:[a-zA-Z\$]+}", new AjaxController($Options), $nameRoute->ajax(), self::NameModule
        );


        $router->addRoute_get(
                "/files/{controle:[a-zA-Z0-9\_\$\-]+}", new FileController($Options), $nameRoute->files(), self::NameModule
        );
    }

}
