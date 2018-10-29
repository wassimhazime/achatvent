<?php

$ROOT = dirname(dirname(__DIR__));
//if (is_file($ROOT . "/public/index.php")) {
//    require $ROOT . "/public/index.php";
//} else {
//    require $ROOT . "/index.php";
//}

require  $ROOT . "/Bootstrap/define.php";


use Kernel\AWA_Interface\ModelInterface;
use Psr\Http\Message\ServerRequestInterface;




$container = $app->getContainer();

$Request = $container->get(ServerRequestInterface::class);

$Response = $app->run($Request);// ===> not run method charge and run

$pathModules = $app->getPathModules();

$migrations = array_map(function(string $pathModule): string {
    return $pathModule . "/phinix_db/migrations";
}, $pathModules);

$seeds = array_map(function(string $pathModule): string {
    return $pathModule . "/phinix_db/seeds";
}, $pathModules);

$PDO = $container->get(ModelInterface::class)->getDatabase();
$DBname = $container->get(ModelInterface::class)->getDBnames();
return [
    "paths" => [
        "migrations" => $migrations,
        "seeds" => $seeds
    ]
    , 'environments' =>
    [
        'default_database' => 'development',
        'development' => [
            "name" => $DBname,
            'connection' => $PDO
        ]
    ]
];


