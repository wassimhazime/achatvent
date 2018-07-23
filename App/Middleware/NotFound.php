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

/**
 * Description of Midd_psR15
 *
 * @author wassime
 */
class NotFound implements MiddlewareInterface {

    private $call;

    function __construct(callable $call) {
        $this->call = $call;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {

        $Response = $handler->handle($request);
        $code = $Response->getStatusCode();

        if ($code === 404 || $Response->getBody()->getSize() === 0) {
            // is json page not found
            $HeaderLine = $Response->getHeaderLine("Content-Type");
            if (strpos($HeaderLine, "json") > 0) {
                $Response->getBody()->write("{}");
            } else {
                $Response = call_user_func($this->call, $Response);
            }
            return $Response->withStatus(404);
        }

        return $Response;
    }

}
