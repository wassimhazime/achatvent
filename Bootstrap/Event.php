<?php

use App\Authentification\Autorisation_init;
use Kernel\AWA_Interface\ModelInterface;


    $container = $app->getContainer();

    $modules = $app->getModules();
    $model = $container->get(ModelInterface::class);


    $app->addEvent("autorisation_init", new Autorisation_init($model, $modules));

    //$app->addEvent("add", "code");
