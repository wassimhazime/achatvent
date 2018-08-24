<?php

require __DIR__ .'/vendor/robmorgan/phinx/app/web.php';
die();



use App\Middleware\NotFound;
use Kernel\AWA_Interface\RendererInterface;
use Kernel\AWA_Interface\RouterInterface;
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

if (php_sapi_name() != "cli") {
    require __DIR__ . "/bootstrap.php";
    $app->addEvent("exeption", "code");
    $app->addEvent("add", "code");

    $app->addMiddleware(new Whoops());
    $app->addMiddleware(new Middlewares\PhpSession());
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
}




























