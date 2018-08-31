<?php

namespace App\Modules\CRM;

use Kernel\AWA_Interface\RouterInterface;
use App\AbstractModules\AbstractModule;
use Kernel\AWA_Interface\RendererInterface;

use App\Modules\CRM\{
    Controller\SendController,
    Controller\ShowController,
    Controller\AjaxController,
    Controller\FileController
};

class CRMModule extends AbstractModule {

    protected $Controllers = [
        "clients",
        'raison$sociale',
        'contacts',
        'mode$paiement'];
    const NameModule = "CRM";
    const IconModule = " fa fa-fw fa-stack-overflow ";
    
 public function addPathRenderer(RendererInterface $renderer) {
        $pathModule = __DIR__ . D_S . "views" . D_S;
        $renderer->addPath($pathModule, self::NameModule);
    }
    public function addRoute(RouterInterface $router) {
        $nameRoute = $this->getNamesRoute();

        $Options = ["container" => $this->getContainer(),
            "namesControllers" => $this->Controllers,
            "nameModule" => self::NameModule,
            "middlewares" => $this->middlewares,
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

//     public function CREATE_TABLE_autorisation_sql(): string {
//        $name = '$' . $this::NameModule;
//        $id = $this::NameModule;
//
//        return "
//           
//
//        CREATE TABLE IF NOT EXISTS `autorisation$name` (
//          `id` int(10) NOT NULL AUTO_INCREMENT,
//          `comptes` int(11) NOT NULL,
//          `controller` varchar(200) NOT NULL,
//          `voir` tinyint(4) DEFAULT 1,
//          `ajouter` tinyint(4) DEFAULT 1,
//          `modifier` tinyint(4) DEFAULT 1,
//          `effacer` tinyint(4) DEFAULT 1,
//          `active` tinyint(4) DEFAULT 1,
//          `date_ajoute` datetime NOT NULL,
//          `date_modifier` datetime NOT NULL,
//          
//          PRIMARY KEY (`id`),
//          
//          KEY `autorisation_$id` (`comptes`)
//        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
//
//
//        ALTER TABLE `autorisation$name`
//          ADD CONSTRAINT `autorisation_$id` FOREIGN KEY (`comptes`) REFERENCES `comptes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
//
//
//
//
//      ";
//    }

}
