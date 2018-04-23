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
class Route
{
    
    
    private $callable;
    private $name;
    private $params;
   
    function __construct($callable, $name, $params)
    {
        $this->callable = $callable;
        $this->name = $name;
        $this->params = $params;
    }
    function getCallable()
    {
        return $this->callable;
    }

    function getName()
    {
        return $this->name;
    }

    function getParams()
    {
        return $this->params;
    }

    
    
    function getParam(string $index)
    {
        if (isset($this->params[$index])) {
            return $this->params[$index];
        }
    }
    function setCallable($callable)
    {
        $this->callable = $callable;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function setParams($params)
    {
        $this->params = $params;
    }
}
