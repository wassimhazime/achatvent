<?php
define('D_S', DIRECTORY_SEPARATOR);
//define('ROOT', dirname(__DIR__) . D_S);
define('ROOT', __DIR__ . D_S);
require ROOT . "vendor/autoload.php";
use Kernel\AWA_Interface\ModelInterface;
use Kernel\Container\Factory_Container;
$container = Factory_Container::getContainer(ROOT . "Config" . D_S . "Config_Container.php");





return [
    "paths" => [
        "migrations" => [
            __DIR__ . '/db/migrations',
            __DIR__ . '/db/m2'
        ],
        "seeds" => __DIR__ . '/db/seeds'
    ]
    , 'environments' =>
    [
        'default_database' => 'development',
        'development' => [
            "name" => "comptable",
            'connection' => $container->get(ModelInterface::class)->get_PDO()
        ]
    ]
];
