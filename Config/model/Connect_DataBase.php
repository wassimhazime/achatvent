<?php

$Bootstrap = ["BOOT" => "docker"];

/* * *********************** */

$TEST = ["docker" => [
        "cache" => true, // permission file
        "dsn" => "mysql:host=database",
        "dbuser" => "root",
        "dbpass" => "root",
        "dbname" => "vtest"
        ]];
$PROD = ["local" => [
        "cache" => false,
        "dsn" => "mysql:host=localhost",
        "dbuser" => "root",
        "dbpass" => "root",
        "dbname" => "comptable"
        ]];
$google = ["google" => [
        "cache" => false,
        "dsn" => "mysql:dbname=vtest;unix_socket=/cloudsql/root",
        "dbuser" => "root",
        "dbpass" => "root",
        "dbname" => "comptable"
        ]];

return array_merge($Bootstrap, $TEST, $PROD,$google);

