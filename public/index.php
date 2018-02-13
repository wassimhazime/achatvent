<?php

require dirname(__DIR__) . "/vendor/autoload.php";


use App\App;
use App\Modules\Achat\Module;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use function Http\Response\send;
define('D_S', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__DIR__).D_S);




$app = new App("Config_Container.php");

$app->addModule(\App\Modules\Achat\Module::class);
$app->addModule(\App\Modules\test\Module::class);

$Response = $app->run(ServerRequest::fromGlobals(), new Response());

send($Response);

















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