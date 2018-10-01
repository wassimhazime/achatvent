<?php

$Bootstrap = ["BOOT" => "TEST"];

/* * *********************** */

$TEST = ["TEST" => [
        "cache" => false, // permissio file
        "DB" => "mysql",
        "dbhost" => "database",
        "dbuser" => "root",
        "dbpass" => "root",
        "dbname" => "vtest"
        ]];
$PROD = ["PROD" => [
        "cache" => true,
        "DB" => "mysql",
        "dbhost" => "localhost",
        "dbuser" => "comptable",
        "dbpass" => "achrafwassim",
        "dbname" => "comptable"
        ]];


return array_merge($Bootstrap, $TEST, $PROD);

