<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Router;

/**
 * Description of Route
 *
 * @author wassime
 */
class Route {

    private $success;
    private $middleware;
    private $name;
    private $params;

    function __construct($middleware, $name, $params,$success=true) {
        $this->middleware = $middleware;
        $this->name = $name;
        $this->params = $params;
        $this->success=$success;
    }
    function isSuccess(): bool {
        return $this->success; 
    }
    function getMiddleware() {
        return $this->middleware;
    }

    function getName() {
        return $this->name;
    }

    function getParams() {
        return $this->params;
    }

    function getParam(string $index) {
        if (isset($this->params[$index])) {
            return $this->params[$index];
        }
    }

    function setMiddleware($middleware) {
        $this->middleware = $middleware;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setParams($params) {
        $this->params = $params;
    }

}
