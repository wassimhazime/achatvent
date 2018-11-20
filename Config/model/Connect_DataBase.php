<?php

$Bootstrap = ["BOOT" => "local"];

/* * *********************** */

$TEST = ["docker" => [
        "cache" => false, // permissio file
        "DB" => "mysql",
        "dbhost" => "database",
        "dbuser" => "root",
        "dbpass" => "root",
        "dbname" => "vtest"
        ]];
$PROD = ["local" => [
        "cache" => false,
        "DB" => "mysql",
        "dbhost" => "localhost",
        "dbuser" => "root",
        "dbpass" => "root",
        "dbname" => "comptable"
        ]];


return array_merge($Bootstrap, $TEST, $PROD);

