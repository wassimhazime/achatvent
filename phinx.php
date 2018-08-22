<?php

use Kernel\AWA_Interface\ModelInterface;

require "index.php";
$PDO = $container->get(ModelInterface::class)->getDatabase();

$pathModules = $app->getPathModules();

$migrations = array_map(function(string $pathModule): string {
    return $pathModule . "/phinix_db/migrations";
}, $pathModules);

$seeds = array_map(function(string $pathModule): string {
    return $pathModule . "/phinix_db/seeds";
}, $pathModules);

return [
    "paths" => [
        "migrations" => $migrations,
        "seeds" => $seeds
    ]
    , 'environments' =>
    [
        'default_database' => 'development',
        'development' => [
            "name" => "app",
            'connection' => $PDO
        ]
    ]
];
