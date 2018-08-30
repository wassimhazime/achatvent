<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of App
 *
 * @author wassime
 */

namespace App;

use Kernel\AWA_Interface\ModelInterface;
use Kernel\AWA_Interface\ModuleInterface;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\Kernel;
use function array_merge;
use function is_a;

class App extends Kernel {

    private $appliction = [];

    function run_modules() {
        $router = $this->container->get(RouterInterface::class);
        $renderer = $this->container->get(RendererInterface::class);

        $menus = [];
        foreach ($this->modules as $_module) {
            $class_module = $_module["module"];
            $middlewares = $_module["middlewares"];

            $module = new $class_module($this->container);
            $this->setAppliction($module);
            if (is_a($module, ModuleInterface::class)) {

                $module->autorisation($this->appliction);
                $module->addRoute($router, $middlewares);
                $module->addPathRenderer($renderer);
                $menu = $module->getMenu();
                $menus = array_merge($menus, $menu);
            }
        }


        $renderer->addGlobal("_Router", $router);
        $renderer->addGlobal("_menu", $menus);
        $this->Autorisation_init();
    }

    function setAppliction(ModuleInterface $module) {
        foreach ($module->getControllers() as $controller) {
            $this->appliction[$module::NameModule][] = ["controller" => $controller];
        }
    }

    public function Autorisation_init() {
        $autor = new Autorisation($this->container->get(ModelInterface::class));
        foreach ($this->appliction as $nameModul => $namecontrollers) {
            $autor->Autorisation_init($nameModul, $namecontrollers);
        }
    }

}
