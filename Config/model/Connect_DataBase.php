<?php

$Bootstrap = ["BOOT" => "TEST"];

/* * *********************** */

$TEST = ["TEST" => [
        "cache" => false,
        "DB" => "mysql",
        "dbhost" => "localhost",
        "dbuser" => "root",
        "dbpass" => "root",
        "dbname" => "app"
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

