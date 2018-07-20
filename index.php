<?php

date_default_timezone_set("Africa/Casablanca");
define('D_S', DIRECTORY_SEPARATOR);
//define('ROOT', dirname(__DIR__) . D_S);
define('ROOT', __DIR__ . D_S);
require ROOT . "vendor/autoload.php";

use App\App;
use GuzzleHttp\Psr7\ServerRequest;
use function Http\Response\send;

//$app->addModule("achat", ["Middlewareauto"], ["event"]);
//$app->addModule("vente", ["Middlewareauto"]);
//$app->addModule("charge", ["Middlewareauto"]);
//$app->addModule("pub");



$app = new App(ROOT . "Config" . D_S . "Config_Container.php");
$app->addMiddleware(new \Middlewares\Whoops());

$app->addModule(\App\Modules\Statistique\StatistiqueModule::class);
$app->addModule(\App\Modules\Comptable\ComptableModule::class);
$app->addModule(\App\Modules\Transactions\TransactionsModule::class);



$app->addEvent("exeption", "code");
$app->addEvent("add", "code");


$Response = $app->run(ServerRequest::fromGlobals());

send($Response);





























