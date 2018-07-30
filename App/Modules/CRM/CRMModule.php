<?php

namespace App\Modules\CRM;

use App\AbstractModules\AbstractModule;
use App\Modules\CRM\Controller\TraitementSendController;
use App\Modules\CRM\Controller\TraitementShowController;
use App\Modules\CRM\Controller\VoirController;
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

    public function addPathRenderer(RendererInterface $renderer)
    {
        $pathModule = __DIR__ . D_S . "views" . D_S;
        $renderer->addPath($pathModule . "show", "CRMShow");
        $renderer->addPath($pathModule . "traitement", "CRMTraitement");
    }

    public function addRoute(RouterInterface $router, array $middlewares)
    {

        $router->addRoute_get(
            "/CRM/{action:[a-z]+}-{controle:[a-z\$]+}",
            new VoirController($this->container, self::Controllers),
            "CRMVoirGet"
        );


        $router->addRoute_get(
            "/CRM/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9\,]+}",
            new TraitementShowController($this->container, self::Controllers),
            "CRMTraitementShow"
        );


        $router->addRoute_post(
            "/CRM/{action:[a-z]+}-{controle:[a-z\$]+}-{id:[0-9]+}",
            new TraitementSendController($this->container, self::Controllers),
            "CRMTraitementSend"
        );


        $router->addRoute_get(
            "/CRM/ajaxCRM/{controle:[a-z\$]+}",
            new Controller\AjaxController($this->container, self::Controllers),
            "CRMAjax"
        );


        $router->addRoute_get(
            "/CRM/files/{controle:[a-z0-9\_\$\-]+}",
            new Controller\FileController($this->container, self::Controllers),
            "CRMFiles"
        );
    }

    // //////////////////////
    public function getMenu(): array
    {
        $menu = [
            [
                "nav_title" => "CRM",
                "nav_icon" => ' fa fa-fw fa-stack-overflow ',
                "nav" => $this->generateUriMenu("CRMVoirGet", self::Controllers)
            ]
        ];

        return $menu;
        // // "group"=> [[lable,url],....]
    }
}
