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

use App\Authentification\Comptes\ComptesModule;
use App\Authentification\Login\LoginModule;
use Kernel\Kernel;

class App extends Kernel {

    private static $app = null;

    public static function getApp(string $pathconfig) :self{
        if (self::$app === null) {
            self::$app = new self($pathconfig);
            return self::$app;
        }
        return self::$app;
    }

    public function run_modules() {
        $this->gestion_compte();
        $modules = $this->getModules();


        $menus = [];
        foreach ($modules as $module) {

            $module->addRoute($this->router);
            $module->addPathRenderer($this->renderer);
            $menus[] = $module->getMenu();
        }

        $this->renderer->addGlobal("_Router", $this->router);
        $this->renderer->addGlobal("_menu", $menus);
    }

    private function gestion_compte() {

        $Comptes = new ComptesModule($this->container);
        // $login=new LoginModule($this->container);
        $modules = $this->getModules();
        $Comptes->setModules($modules);
        $this->addModule($Comptes);
        // $this->addModule($login);
    }

}
