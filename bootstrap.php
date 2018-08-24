<?php

//phpinfo();die();
date_default_timezone_set("Africa/Casablanca");
define('D_S', DIRECTORY_SEPARATOR);
//define('ROOT', dirname(__DIR__) . D_S);
define('ROOT', __DIR__ . D_S);
require ROOT . "vendor" . D_S . "autoload.php";

use App\Modules\Comptes\ComptesModule;
use App\Modules\Statistique\StatistiqueModule;
use App\Modules\CRM\CRMModule;
use App\Modules\Achats\AchatsModule;
use App\Modules\Ventes\VentesModule;
use App\Modules\Transactions\TransactionsModule;
use Kernel\Container\Factory_Container;
use Middlewares\BasicAuthentication;
use App\App;

$pathconfig = ROOT . "Config" . D_S . "Config_Container.php";
$container = Factory_Container::getContainer($pathconfig);
$app = new App($container);

$app->addModule(StatistiqueModule::class);
$app->addModule(CRMModule::class);
$app->addModule(AchatsModule::class);
$app->addModule(VentesModule::class);
$app->addModule(TransactionsModule::class, [
    new \App\Middleware\Authentification()
        ]
);
$app->addModule(ComptesModule::class);


