<?php

define('D_S', DIRECTORY_SEPARATOR);
//define('ROOT', dirname(__DIR__) . D_S);
define('ROOT', __DIR__. D_S);
require ROOT . "vendor/autoload.php";

use App\App;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ServerRequest;
use function Http\Response\send;

$app = new App(ROOT . "back_end" . D_S . "Config" . D_S . "Config_Container.php");
$app->addModule(\App\Modules\Vente\Module::class);
$app->addModule(\App\Modules\Achat\Module::class);



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