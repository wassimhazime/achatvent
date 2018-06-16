<?php
date_default_timezone_set("Africa/Casablanca");
define('D_S', DIRECTORY_SEPARATOR);
//define('ROOT', dirname(__DIR__) . D_S);
define('ROOT', __DIR__ . D_S);
require ROOT . "vendor/autoload.php";


use App\App;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use function Http\Response\send;

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


// start application
$start = microtime(true);


$app = new App(ROOT . "Config" . D_S . "Config_Container.php");

$app->addModule(\App\Modules\Statistique\StatistiqueModule::class);
$app->addModule(\App\Modules\Comptable\ComptableModule::class);
$app->addModule(\App\Modules\Transactions\TransactionsModule::class);




$Response = $app->run(ServerRequest::fromGlobals(), new Response());

send($Response);






$fin = round(microtime(true) - $start, 5);

//echo"<h5>". $fin.' secondes </h5>';
















//$app->addModule("achat", ["Middlewareauto"], ["event"]);
//$app->addModule("vente", ["Middlewareauto"]);
//$app->addModule("charge", ["Middlewareauto"]);
//$app->addModule("pub");
//
//$app->addEvent("exeption", "code");
//$app->addEvent("add", "code");
//
//
//$app->addMiddleware("csrf");
//$app->addMiddleware("whoop");