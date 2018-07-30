<?php

namespace App\Modules\Achats;

use App\AbstractModules\AbstractModule;
use App\Modules\Achats\Controller\TraitementSendController;
use App\Modules\Achats\Controller\TraitementShowController;
use App\Modules\Achats\Controller\VoirController;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use const D_S;

class AchatsModule extends AbstractModule
{

    const Controllers = [
        'commandes',
        'bons$achats',
        'factures$achats',
        'avoirs$achats'
    ];

    public function addPathRenderer(RendererInterface $renderer)
    {
        $pathModule = __DIR__ . D_S . "views" . D_S;
        $renderer->addPath($pathModule . "show", "AchatsShow");
        $renderer->addPath($pathModule . "traitement", "AchatsTraitement");
    }

    public function addRoute(RouterInterface $router, array $middlewares)
    {

        $router->addRoute_get("/Achats/{action:[a-z]+}-{controle:[a-z\$]+}", new VoirController($this->container, self::Controllers), "AchatsVoirGet");


        $router->addRoute_get("/Achats/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9\,]+}", new TraitementShowController($this->container, self::Controllers), "AchatsTraitementShow");


        $router->addRoute_post("/Achats/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}", new TraitementSendController($this->container, self::Controllers), "AchatsTraitementSend");


        $router->addRoute_get("/Achats/ajaxAchats/{controle:[a-z\$]+}", new Controller\AjaxController($this->container, self::Controllers), "AchatsAjax");


        $router->addRoute_get("/Achats/files/{controle:[a-z0-9\_\$\-]+}", new Controller\FileController($this->container, self::Controllers), "AchatsFiles");
    }

    // //////////////////////
    public function getMenu(): array
    {






        $menu = [
            [
                "nav_title" => "achats",
                "nav_icon" => ' fa fa-fw fa-shopping-cart ',
                "nav" => $this->generateUriMenu("AchatsVoirGet", self::Controllers)
            ]
        ];

        return $menu;
        // // "group"=> [[lable,url],....]
    }
}
