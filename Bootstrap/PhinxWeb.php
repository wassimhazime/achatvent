<?php

/**
 * migrate par web 
 * true or false
 */
if (false) {




// This script can be run as a router with the built in PHP web server:
//
// This script uses the following query string arguments:
//
// - (string) "e" environment name
// - (string) "t" target version
// - (boolean) "debug" enable debugging?
// Get the phinx console application and inject it into TextWrapper.

    if (php_sapi_name() != "cli") {

        $appphinix = new Phinx\Console\PhinxApplication();

        $wrap = new Phinx\Wrapper\TextWrapper($appphinix);

// Mapping of route names to commands.
        $routes = [
            'status' => 'getStatus',
            'migrate' => 'getMigrate',
            'rollback' => 'getRollback',
        ];

// Extract the requested command from the URL, default to "status".
        $command = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        if (!$command) {
            $command = 'status';
        }

// Verify that the command exists, or list available commands.
        if (!isset($routes[$command])) {
            $commands = implode(', ', array_keys($routes));
            header('Content-Type: text/plain', true, 404);
            die("Command not found! Valid commands are: {$commands}.");
        }

// Get the environment and target version parameters.
        $env = isset($_GET['e']) ? $_GET['e'] : null;
        $target = isset($_GET['t']) ? $_GET['t'] : null;

// Check if debugging is enabled.
        $debug = !empty($_GET['debug']) && filter_var($_GET['debug'], FILTER_VALIDATE_BOOLEAN);




// Execute the command and determine if it was successful.
        $output = call_user_func([$wrap, $routes[$command]], $env, $target);
        $error = $wrap->getExitCode() > 0;








// Finally, display the output of the command.
        header('Content-Type: text/plain', true, $error ? 500 : 200);
        if ($debug) {
            // Show what command was executed based on request parameters.
            $args = implode(', ', [var_export($env, true), var_export($target, true)]);
            echo "DEBUG: $command($args)" . PHP_EOL . PHP_EOL;
        }
        echo $output;
        die();
    }
}