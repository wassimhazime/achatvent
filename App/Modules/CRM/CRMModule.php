<?php

namespace App\Modules\CRM;

use App\AbstractModules\AbstractModule;
use App\Modules\CRM\Controller\SendController;
use App\Modules\CRM\Controller\ShowController;
use App\Modules\CRM\Controller\AjaxController;
use App\Modules\CRM\Controller\FileController;

use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use const D_S;

class CRMModule extends AbstractModule
{

    const Controllers = [
        "clients",
        'raison$sociale',
        'contacts',
        'mode$paiement'];
    
    const NameModule="CRM";
     const IconModule = " fa fa-fw fa-stack-overflow ";

    public function addPathRenderer(RendererInterface $renderer)
    {
        $pathModule = __DIR__ . D_S . "views" . D_S;
        $renderer->addPath($pathModule . "show", self::NameModule."Show");
        $renderer->addPath($pathModule . "traitement", self::NameModule."Traitement");
    }

    public function addRoute(RouterInterface $router, array $middlewares)
    {
        
        $Options=["container"=>$this->getContainer(),
            "namesControllers"=>self::Controllers,
            "nameModule"=> self::NameModule,
            "middlewares"=>$middlewares
            ];

       $router->addRoute_get(
            "/{controle:[a-z\$]+}[/{action:[a-z]+}-{id:[0-9\,]+}]",
            new ShowController($Options),
            $this->getNamesRoute()->show(),
           self::NameModule
        );


        $router->addRoute_post(
            "/{controle:[a-z\$]+}/{action:[a-z]+}-{id:[0-9]+}",
            new SendController($Options),
            $this->getNamesRoute()->send(),
           self::NameModule
        );


        $router->addRoute_get(
            "/ajax/{controle:[a-z\$]+}",
            new AjaxController($Options),
            $this->getNamesRoute()->ajax(),
           self::NameModule
        );


        $router->addRoute_get(
            "/files/{controle:[a-z0-9\_\$\-]+}",
            new FileController($Options),
            $this->getNamesRoute()->files(),
           self::NameModule
        );
    }

    // //////////////////////
 
}
