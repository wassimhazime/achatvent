<?php

namespace App\Modules\CRM;

use Kernel\AWA_Interface\RouterInterface;
use App\AbstractModules\AbstractModule;
use Kernel\AWA_Interface\RendererInterface;

use App\Modules\CRM\Controller\SendController;
use App\Modules\CRM\Controller\ShowController;
use App\Modules\CRM\Controller\AjaxController;
use App\Modules\CRM\Controller\FileController;

class CRMModule extends AbstractModule
{

    protected $Controllers = [
        "clients",
        'raison$sociale',
        ['contacts'=>['notSelect'=>['raison$sociale']]]
        ];
    const NameModule = "CRM";
    const IconModule = " fa fa-fw fa-stack-overflow ";

    public function addPathRenderer(RendererInterface $renderer)
    {

        $NamesControllers=$this->getNamesControllers($this->Controllers);
        foreach ($NamesControllers as $NameController ) {
          $pathModule = __DIR__ . D_S . "views" . D_S.$NameController.D_S;

          $renderer->addPath($pathModule, self::NameModule.$NameController);
        }

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
