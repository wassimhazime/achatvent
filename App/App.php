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

use Kernel\AWA_Interface\InterfaceRenderer;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\Kernel;
use function array_merge;
use function class_exists;

class App extends Kernel {

    function save_modules() {
        $this->router = $this->container->get(RouterInterface::class);
        $renderer = $this->container->get(InterfaceRenderer::class);
        $pathModules = $this->container->get("pathModules");
        $menu = [];
        foreach ($this->modules as $module) {
            if (class_exists($module)) {
                $m = new $module($this->container);
                $m->addRoute($this->router);
                $m->addPathRenderer($renderer, $pathModules);
                $menu = array_merge($menu, $m->dataMenu());
            }
        }
        $renderer->addGlobal("router", $this->router);
        $renderer->addGlobal("_menu", $menu);
    }

}
