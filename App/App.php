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

use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\AWA_Interface\ModuleInterface;
use Kernel\Kernel;
use function array_merge;
use function is_a;

class App extends Kernel {

    function run_modules() {
        $router = $this->container->get(RouterInterface::class);
        $renderer = $this->container->get(RendererInterface::class);
        $pathModules = $this->container->get("pathModules");
        $menus = [];
        foreach ($this->modules as $_module) {
            $class_module=$_module["module"];
            $middlewares=$_module["middlewares"];
            
            $module = new $class_module($this->container);
            if (is_a($module, ModuleInterface::class)) {
                $module->addRoute($router,$middlewares);
                $module->addPathRenderer($renderer, $pathModules);
                $menu = $module->getMenu();
                $menus = array_merge($menus, $menu);
            }
        }


        $renderer->addGlobal("router", $router);
        $renderer->addGlobal("_menu", $menus);
    }

}
