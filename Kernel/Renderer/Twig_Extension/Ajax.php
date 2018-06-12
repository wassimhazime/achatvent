<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Renderer\Twig_Extension;

class Ajax extends \Twig_Extension {

    public function getFunctions() {
        return [
          
            new \Twig_SimpleFunction("Ajax", [$this, "Ajax"], ['is_safe' => ['html'], 'needs_context' => true]),
        ];
    }

    public function Ajax(array $context, string $nameroute): string {
        $page = $context["_page"]; // class controller main
        $router = $context["router"]; // class App
        $url = [];

        return  $router->generateUri($nameroute, ["controle" => $page]);
  
        }

   
    

}
