<?php

use App\App;
use Psr\Http\Message\ServerRequestInterface;
use function Http\Response\send;
require_once  "define.php";
require_once ROOT . "vendor" . D_S . "autoload.php";
/**
 *  configue container
 */
$configue = ROOT . "Config" . D_S . "Config_Container.php";
/**
 * creer application and set configue container
 */
$app = new App($configue);

/**
 * set le module de applicaton
 */
require ROOT . "Bootstrap" . D_S . "Module.php";

/**
 * is sow to web (not console)
 */
if (php_sapi_name() != "cli") {
    /**
     * set event
     */
    require ROOT . "Bootstrap" . D_S . "Event.php";
    /**
     * set event
     */
    require ROOT . "Bootstrap" . D_S . "Middlewares.php";
    /**
     * migrate par web si besoin
     * true or false
     */
    require_once ROOT . "Bootstrap" . D_S . "PhinxWeb.php";
}

/**
 * run app
 */
$container = $app->getContainer();
$Request = $container->get(ServerRequestInterface::class);
$Response = $app->run($Request);
if (php_sapi_name() != "cli") {
    send($Response);
}

