<?php

namespace App\Modules\Ventes;

use App\AbstractModules\AbstractModule;
use App\Modules\Ventes\Controller\TraitementSendController;
use App\Modules\Ventes\Controller\TraitementShowController;
use App\Modules\Ventes\Controller\VoirController;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use const D_S;

class VentesModule extends AbstractModule
{

    const Controllers = [
                   'devis',
            'factures$ventes'
    ];

    public function addPathRenderer(RendererInterface $renderer)
    {
        $pathModule = __DIR__ . D_S . "views" . D_S;
        $renderer->addPath($pathModule . "show", "VentesShow");
        $renderer->addPath($pathModule . "traitement", "VentesTraitement");
    }

    public function addRoute(RouterInterface $router, array $middlewares)
    {

        $router->addRoute_get("/Ventes/{action:[a-z]+}-{controle:[a-z\$]+}", new VoirController($this->container, self::Controllers), "VentesVoirGet");


        $router->addRoute_get("/Ventes/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9\,]+}", new TraitementShowController($this->container, self::Controllers), "VentesTraitementShow");


        $router->addRoute_post("/Ventes/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", new TraitementSendController($this->container, self::Controllers), "VentesTraitementSend");


        $router->addRoute_get("/Ventes/ajaxVentes/{controle:[a-z\$]+}", new Controller\AjaxController($this->container, self::Controllers), "VentesAjax");


        $router->addRoute_get("/Ventes/files/{controle:[a-z0-9\_\$\-]+}", new Controller\FileController($this->container, self::Controllers), "VentesFiles");
    }

    // //////////////////////
    public function getMenu(): array
    {





        $menu = [
            [
                "nav_title" => "ventes",
                "nav_icon" => ' fa fa-fw fa-usd   ',
                "nav" => $this->generateUriMenu("VentesVoirGet", self::Controllers)
            ]
        ];

        return $menu;
        // // "group"=> [[lable,url],....]
    }
}
