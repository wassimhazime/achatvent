<?php

namespace App\AbstractModules;

use Kernel\AWA_Interface\ModuleInterface;
use App\Modules\Statistique\Controller\globalController;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use Psr\Container\ContainerInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AbstractModule
 *
 * @author wassime
 */
abstract class AbstractModule implements ModuleInterface {

    protected $container;
    protected $router;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->router = $this->container->get(RouterInterface::class);
    }

    protected function generateUriMenu(string $name_route, array $info): array {
        $infogenerate = [];
        foreach ($info as $controle) {
            $url = $this->router->generateUri($name_route, ["controle" => $controle, "action" => "voir"]);
            $label = str_replace("$", "  ", $controle);
            $infogenerate[$label] = $url;
        }
        return $infogenerate;
    }

}
