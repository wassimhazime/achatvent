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

                $this->gestion_comptes($module->CREATE_TABLE_autorisation_sql(),$module::NameModule,$module->getControllers());
            }
        }


        $renderer->addGlobal("_Router", $router);
        $renderer->addGlobal("_menu", $menus);
    }

    function setAppliction(ModuleInterface $module) {
        foreach ($module->getControllers() as $controller) {
            $this->appliction[$module::NameModule][] = ["controller" => $controller];
        }
    }

    public function gestion_comptes($sql,$nameModul,$namecontrollers) {
        $model = new \App\AbstractModules\Model\AbstractModel($this->container->get("pathModel"));
        $model->exec($sql);
        
        
     
       $id_comptes=[];
       foreach ($model->querySimple("select id from comptes") as $value) {
          $id_comptes[] =$value["id"];
       }
       $id_comptes_setModule=[];
        foreach ($model->querySimple('select comptes from autorisation$' . $nameModul) as $value) {
          $id_comptes_setModule[] =$value["comptes"];
       }
       $id_comptes_setModule=array_unique($id_comptes_setModule);
      
       
       $table = 'autorisation$' . $nameModul;
       $model->setTable($table);
       
       foreach ($id_comptes as $id) {
           if(!in_array($id, $id_comptes_setModule)){
               $compte = ["comptes" => $id];
              foreach ($namecontrollers as $namecontroller) {
                    $d = array_merge(["controller" => $namecontroller], $compte);
                    $model->setData($d);
                } 
           }
           
       }
        
     
        
    }

}
