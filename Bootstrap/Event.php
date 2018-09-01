<?php

use App\Authentification\Autorisation_init;
use Kernel\AWA_Interface\ModelInterface;

if (php_sapi_name() != "cli") {


    $container = $app->getContainer();
    /////////////////////////////////////////////
    /**
     * event
     */
    $modules = $app->getModules();
    $model = $container->get(ModelInterface::class);


    $app->addEvent("autorisation_init", new Autorisation_init($model, $modules));

    //$app->addEvent("add", "code");
}