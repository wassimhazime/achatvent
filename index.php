<?php

date_default_timezone_set("Africa/Casablanca");
define('D_S', DIRECTORY_SEPARATOR);
//define('ROOT', dirname(__DIR__) . D_S);
define('ROOT', __DIR__ . D_S);
require ROOT . "vendor/autoload.php";

use App\App;
use App\Middleware\NotFound;
use Kernel\AWA_Interface\InterfaceRenderer;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\Container\Factory_Container;
use Middlewares\BasicAuthentication;
use Middlewares\ContentEncoding;
use Middlewares\ContentLanguage;
use Middlewares\ContentType;
use Middlewares\CssMinifier;
use Middlewares\HtmlMinifier;
use Middlewares\JsMinifier;
use Middlewares\ResponseTime;
use Middlewares\Whoops;
use Psr\Http\Message\ServerRequestInterface;
use function Http\Response\send;

//$app->addModule("achat", ["Middlewareauto"], ["event"]);
//$app->addModule("vente", ["Middlewareauto"]);
//$app->addModule("charge", ["Middlewareauto"]);
//$app->addModule("pub");

$container = Factory_Container::getContainer(ROOT . "Config" . D_S . "Config_Container.php");

$app = new App($container);
$app->addMiddleware(new Whoops());
$app->addMiddleware((new BasicAuthentication([
    'username1' => 'password1',
    'aa' => 'a'
        ]
        ))->attribute('username')
);


$app->addModule(\App\Modules\Statistique\StatistiqueModule::class);
$app->addModule(\App\Modules\Comptable\ComptableModule::class);
$app->addModule(\App\Modules\Transactions\TransactionsModule::class);
$app->save_modules();



$app->addMiddleware(new CssMinifier());
$app->addMiddleware(new JsMinifier());
$app->addMiddleware(new HtmlMinifier());
$app->addMiddleware(new ContentType());
$app->addMiddleware(new ContentLanguage(['fr', 'en', 'ar']));
$app->addMiddleware(new ContentEncoding(['gzip', 'deflate']));


$app->addEvent("exeption", "code");
$app->addEvent("add", "code");

$app->addMiddleware(new ResponseTime());
$Request = $container->get(ServerRequestInterface::class);

$app->addMiddleware(new NotFound(function ($Response) use ($container) {
    // is html page not found
    $render = $container->get(InterfaceRenderer::class)
            ->render("404", ["_page" => "404"]);
    $Response->getBody()->write($render);
    return $Response;
})
);
//rest put delete post .....
$app->addMiddleware(
        $container->get(RouterInterface::class)
                ->match($Request)
                ->getMiddleware()
);


$Response = $app->run($Request);
send($Response);





























