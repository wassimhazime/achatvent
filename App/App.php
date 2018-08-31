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
    private $model;

    function run_modules() {
        $router = $this->container->get(RouterInterface::class);
        $renderer = $this->container->get(RendererInterface::class);
        $this->model = $this->container->get(ModelInterface::class);
        $menus = [];

        foreach ($this->modules as $_module) {
            $class_module = $_module["module"];
            $middlewares = $_module["middlewares"];

            $module = new $class_module($this->container);


            if (is_a($module, ModuleInterface::class)) {
                $this->setAppliction($module);
                /// fiha nadar
                $module->autorisation($this->appliction);

                $module->addRoute($router, $middlewares);
                $module->addPathRenderer($renderer);
                $menus[] = $module->getMenu();
            }
        }


        $renderer->addGlobal("_Router", $router);
        $renderer->addGlobal("_menu", $menus);
        $this->Autorisation_init();
    }

/// fiha nadar
    function setAppliction(ModuleInterface $module) {
        foreach ($module->getControllers() as $controller) {
            $this->appliction[$module::NameModule][] = ["controller" => $controller];
        }
    }

    public function Autorisation_init() {
        /**
         * is set cache=false ==> faire les Autorisation_init
         * optimisation appliction
         * pluse de 6 requete sql annuler
         * ====> git les  id comptes
         * ====> git les id relation par chaque table Autorisation$model
         * ....... 
         */
        if (!$this->model::is_set_cache()) {
            $autorisation = new Autorisation($this->model);
            foreach ($this->appliction as $nameModul => $namecontrollers) {
                $autorisation->Autorisation_init($nameModul, $namecontrollers);
            }
        }
    }

}
