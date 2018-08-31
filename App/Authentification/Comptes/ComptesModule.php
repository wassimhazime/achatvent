<?php

namespace App\Authentification\Comptes;

use Kernel\AWA_Interface\RouterInterface;
use App\AbstractModules\AbstractModule;
use Kernel\AWA_Interface\RendererInterface;
use App\Authentification\Comptes\{
    Controller\SendController,
    Controller\ShowController,
    Controller\AjaxController,
    Controller\FileController
};

class ComptesModule extends AbstractModule {

    private $modules = [];
    protected $Controllers = [
        "comptes"];

    const NameModule = "Comptes";
    const IconModule = " fa fa-fw fa-stack-overflow ";

    function setController($Controller) {
        $this->Controllers[] = $Controller;
    }

    function setModules(array $modules) {
        $this->modules = $modules;
        foreach ($modules as $module) {
            $this->setController('autorisation$' . $module::NameModule);
        }
        $this->set_event_autorisation();
    }

    public function set_event_autorisation() {
        $modules = $this->modules;
        $container = $this->getContainer();
        $eventManager = $container->get(\Kernel\AWA_Interface\EventManagerInterface::class);
        $autorisation = $container->get(\App\Authentification\Autorisation::class);


        $eventManager->attach("autorisation_init", function ($event) use ($modules, $autorisation) {


            foreach ($modules as $module) {
                $controllers = [];
                foreach ($module->getControllers() as $controller) {
                    $controllers[] = $controller;
                }
                $autorisation->Autorisation_init($module::NameModule, $controllers);
            }
        });
    }

    /////////////////////////////////////////////////////////////////////

    public function addPathRenderer(RendererInterface $renderer) {
        $pathModule = __DIR__ . D_S . "views" . D_S;
        $renderer->addPath($pathModule, self::NameModule);
    }

    public function addRoute(RouterInterface $router) {
        $nameRoute = $this->getNamesRoute();


        $this->Controllers = $this->Controllers;



        $Options = ["container" => $this->getContainer(),
            "namesControllers" => $this->Controllers,
            "nameModule" => self::NameModule,
            "middlewares" => $this->middlewares,
            "nameRoute" => $nameRoute,
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
