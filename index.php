<?php

//phpinfo();die();
date_default_timezone_set("Africa/Casablanca");
define('D_S', DIRECTORY_SEPARATOR);
//define('ROOT', dirname(__DIR__) . D_S);
define('ROOT', __DIR__ . D_S);
require ROOT . "vendor/autoload.php";

use App\App;
use App\Middleware\NotFound;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
use Kernel\Container\Factory_Container;
use Middlewares\BasicAuthentication;
use App\Modules\Comptes\ComptesModule;
use Middlewares\ContentEncoding;
use Middlewares\ContentLanguage;
use Middlewares\ContentType;
use Middlewares\CssMinifier;
use Middlewares\HtmlMinifier;
use Middlewares\JsMinifier;
use Middlewares\ResponseTime;
use Middlewares\Whoops;
use Psr\Http\Message\ServerRequestInterface;
use App\Modules\Statistique\StatistiqueModule;
use App\Modules\CRM\CRMModule;
use App\Modules\Achats\AchatsModule;
use App\Modules\Ventes\VentesModule;
use App\Modules\Transactions\TransactionsModule;
use function Http\Response\send;

$container = Factory_Container::getContainer(ROOT . "Config" . D_S . "Config_Container.php");
$app = new App($container);

$app->addEvent("exeption", "code");
$app->addEvent("add", "code");

$app->addMiddleware(new Whoops());

$app->addMiddleware(new Middlewares\PhpSession());

$app->addModule(StatistiqueModule::class);

$app->addModule(CRMModule::class);
//$app->addModule(AchatsModule::class);
//$app->addModule(VentesModule::class);
//$app->addModule(TransactionsModule::class, [
//    new \App\Middleware\Authentification()
//        ]
//);

$app->addModule(ComptesModule::class);



$app->addMiddleware([
    new CssMinifier(),
    new JsMinifier(),
    new HtmlMinifier()
]);

$app->addMiddleware([
    new ContentType(),
    new ContentLanguage(['fr', 'en', 'ar']),
    new ContentEncoding(['gzip', 'deflate'])
]);
$app->addMiddleware(new ResponseTime());










$app->addMiddleware(new NotFound(function ($Response) use ($container) {
    // is html page not found
    $render = $container->get(RendererInterface::class)
            ->render("404", ["_page" => "404"]);
    $Response->getBody()->write($render);
    return $Response;
})
);


$app->addMiddleware($container->get(RouterInterface::class));

$Request = $container->get(ServerRequestInterface::class);
$Response = $app->run($Request);

send($Response);





























