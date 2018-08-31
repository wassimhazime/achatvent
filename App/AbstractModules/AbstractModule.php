<?php

namespace App\AbstractModules;

use Kernel\AWA_Interface\{
    ModuleInterface,
    NamesRouteInterface,
    RouterInterface,
    RendererInterface
};
use Psr\Container\ContainerInterface;
use const D_S;
use function str_replace;
use function ucfirst;

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

    private $container;
    private $router;
    private $namesRoute;
    protected $Controllers;

    const NameModule = "";
    const IconModule = "";

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->router = $this->container->get(RouterInterface::class);
        $this->namesRoute = new \Kernel\Controller\NamesRoute();
        $this->namesRoute->set_NameModule($this::NameModule);
    }

    protected function generateUriMenu(string $name_route, array $Controllers): array {
        $generateUriMenu = [];
        foreach ($Controllers as $controle) {
            $url = $this->getRouter()->generateUri($name_route, ["controle" => $controle]);
            $label = ucfirst(str_replace("$", "  ", $controle));
            $generateUriMenu[$label] = $url;
        }
        return $generateUriMenu;
    }

    function getContainer(): ContainerInterface {
        return $this->container;
    }

    function getRouter(): RouterInterface {
        return $this->router;
    }

    function getNamesRoute(): NamesRouteInterface {
        return $this->namesRoute;
    }

    public function getControllers() {
        return $this->Controllers;
    }

    ///////////////////////////////////////////////////////////


    public function getMenu(): array {
        $menu = [
                    "nav_title" => $this::NameModule,
                    "nav_icon" => $this::IconModule,
                    "nav" => $this->generateUriMenu($this->getNamesRoute()->show(), $this->getControllers())
                ]
        ;

        return $menu;
        // // "group"=> [[lable,url],....]
    }

}
