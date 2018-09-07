<?php

namespace App\Authentification\Login;

use Kernel\AWA_Interface\RouterInterface;
use App\AbstractModules\AbstractModule;
use Kernel\AWA_Interface\RendererInterface;
use App\Authentification\Login\{
    Controller\LoginSendController,
    Controller\LoginFormController

  
};

class LoginModule extends AbstractModule {

    private $modules = [];
    protected $Controllers = [
        "login"];

    const NameModule = "Login";
    const IconModule = " fa fa-fw fa-stack-overflow ";

//    function setController($Controller) {
//        $this->Controllers[] = $Controller;
//    }
//    function setModules(array $modules) {
//        $this->modules = $modules;
//        foreach ($modules as $module) {
//            $this->setController('autorisation$' . $module::NameModule);
//        }
//    }

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
                "/{controle:login}", new LoginFormController($Options), $nameRoute->show(), self::NameModule
        );


        $router->addRoute_post(
                "/{controle:login}", new LoginSendController($Options), $nameRoute->send(), self::NameModule
        );
        
    }

}
