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

use App\Authentification\Autorisation;
use App\Authentification\Comptes\ComptesModule;
use Kernel\AWA_Interface\ModelInterface;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\Kernel;

class App extends Kernel {

    function run_modules() {
        $router = $this->getContainer()->get(RouterInterface::class);
        $renderer = $this->getContainer()->get(RendererInterface::class);
        $modules = $this->getModules(true);

        $menus = [];
        foreach ($modules as $module) {

            $module->addRoute($router);
            $module->addPathRenderer($renderer);
            $menus[] = $module->getMenu();
        }

        $renderer->addGlobal("_Router", $router);
        $renderer->addGlobal("_menu", $menus);
    }

    private function getModules($auto = true): array {
        if ($auto) {
            $Comptes = new ComptesModule($this->container);
            $Comptes->setModules($this->modules);
            $this->modules[] = $Comptes;
        }

        return $this->modules;
    }

    /**
     * path model save
     * phinix ==>migrate
     * @return array string 
     */
    public function getPathModules(): array {

        $this->pathModules[] = dirname(ROOT . str_replace("\\", DS, ComptesModule::class));
        return $this->pathModules;
    }

}
