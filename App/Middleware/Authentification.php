<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function call_user_func;
use function strpos;
use function var_dump;
use function Http\Response\send;

/**
 * Description of Authentification
 *
 * @author wassime
 */
class Authentification implements MiddlewareInterface {

    private $container;

    function __construct($container) {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
       
        $url = $request->getUri()->getPath();
     
        if ($url == "/Login/login") {
            return $handler->handle($request);
        }
        if (isset($_SESSION["aut"]) && !empty($_SESSION["aut"])) {
            $Response = $handler->handle($request);
        } else {

            $r = new \GuzzleHttp\Psr7\Response();
            $Response = $r->withHeader("Location", "/Login/login")->withStatus(403);
        }




        return $Response;















//        if (isset($_SESSION["auth"])) {
//            $response = $handler->handle($request);
//            return $response;
//        }
//
//
//        if ($Response->getStatusCode() === 404) {
//            // is json page not found
//            $HeaderLine = $Response->getHeaderLine("Content-Type");
//            if (strpos($HeaderLine, "json") > 0) {
//                $Response->getBody()->write("{}");
//            } else {
//                // is html page not found
//                $Response = call_user_func($this->call, $Response);
//            }
//            return $Response->withStatus(404);
//        }
//
//        return $Response;
//        die("auth");
    }

}
