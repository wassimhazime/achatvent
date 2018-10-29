<?php

use Psr\Http\Message\ServerRequestInterface;
use function Http\Response\send;

require_once "define.php";




/**
 * is sow to web (not console)
 */
if (php_sapi_name() != "cli") {
    /**
     * set event
     */
    require_once ROOT . "Bootstrap" . D_S . "Event.php";
    /**
     * set Middlewares
     */
    require_once ROOT . "Bootstrap" . D_S . "Middlewares.php";
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

