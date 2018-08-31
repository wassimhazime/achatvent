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

   
    private $model;

    function run_modules() {
        $router = $this->container->get(RouterInterface::class);
        $renderer = $this->container->get(RendererInterface::class);
        $this->model = $this->container->get(ModelInterface::class);
        $menus = [];
        $this->set_event_autorisation();
        foreach ($this->modules as $_module) {
            $class_module = $_module["module"];
            $middlewares = $_module["middlewares"];

            $module = new $class_module($this->container);


            if (is_a($module, ModuleInterface::class)) {
              
               

                $module->addRoute($router, $middlewares);
                $module->addPathRenderer($renderer);
                $menus[] = $module->getMenu();
            }
        }


        $renderer->addGlobal("_Router", $router);
        $renderer->addGlobal("_menu", $menus);
    }



    public function set_event_autorisation() {
        /**
         * is set cache=false ==> faire les Autorisation_init
         * optimisation appliction
         * pluse de 6 requete sql annuler
         * ====> git les  id comptes
         * ====> git les id relation par chaque table Autorisation$model
         * ....... 
         */
        $eventManager = $this->container->get(\Kernel\AWA_Interface\EventManagerInterface::class);
        $modules = $this->modules;
        $container = $this->container;
        $model = $this->model;

        $eventManager->attach("autorisation_init", function ($event) use ($modules, $container, $model) {
            $appliction = [];
            foreach ($modules as $_module) {
                $class_module = $_module["module"];
                $module = new $class_module($container);
                if (is_a($module, ModuleInterface::class)) {
                    foreach ($module->getControllers() as $controller) {
                        $appliction[$module::NameModule][] = ["controller" => $controller];
                    }
                }
            }
            $autorisation = new Autorisation($model);
            foreach ($appliction as $nameModul => $namecontrollers) {
                $autorisation->Autorisation_init($nameModul, $namecontrollers);
            }
        });
    }

}
