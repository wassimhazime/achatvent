<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Description of Despatcher
 *
 * @author wassime
 */
class Despatcher implements RequestHandlerInterface {

    private $middlwares = [];
    private $index = 0;
   

    function getMiddlwares() {
        $midd = null;
        if (isset($this->middlwares[$this->index])) {
            $midd = $this->middlwares[$this->index];
            $this->index++;
        }
        return $midd;
    }

 

    public function pipe(MiddlewareInterface $middleware) {
        $this->middlwares[] = $middleware;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface {
        $m = $this->getMiddlwares();
        if ($m) {
            return $m->process($request, $this);
        } else {
            return new \GuzzleHttp\Psr7\Response();
        }
    }

}
