<?php


use App\App;
use App\Modules\Achats\AchatsModule;
use App\Modules\Comptes\ComptesModule;
use App\Modules\CRM\CRMModule;
use App\Modules\Statistique\StatistiqueModule;
use App\Modules\Transactions\TransactionsModule;
use App\Modules\Ventes\VentesModule;

//phpinfo();die();
date_default_timezone_set("Africa/Casablanca");
define('D_S', DIRECTORY_SEPARATOR);
//define('ROOT', dirname(__DIR__) . D_S);
define('ROOT', __DIR__ . D_S);
require ROOT . "vendor" . D_S . "autoload.php";
//setcookie("jjj", "bb");

$pathconfig = ROOT . "Config" . D_S . "Config_Container.php";
$app = new App($pathconfig);
$app->addModule(ComptesModule::class);
$app->addModule(StatistiqueModule::class);
$app->addModule(CRMModule::class);
$app->addModule(AchatsModule::class);
$app->addModule(VentesModule::class);
$app->addModule(TransactionsModule::class, [
    new \App\Middleware\Authentification()
        ]
);



