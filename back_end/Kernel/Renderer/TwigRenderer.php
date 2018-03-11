<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Renderer;

use Kernel\AWA_Interface\InterfaceRenderer;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Description of TwigRenderer
 *
 * @author wassime
 */
class TwigRenderer implements InterfaceRenderer
{

    private $twig;
    private $loader;
    static $renderer = null;

    function __construct($path)
    {
        
        $this->loader = new Twig_Loader_Filesystem($path."/twig");
        $this->twig = new Twig_Environment($this->loader, array(
            'cache' => false,'debug' => true
        ));
        $this->twig ->addFunction(new \Twig_SimpleFunction("html", function ($context) {
            
            return $context ;
        }, ['is_safe' => ['html']]));
        
        $this->twig ->addFunction(new \Twig_SimpleFunction("awa", function ($context, $context2) {
            
            return $context . "   => ".$context2;
        }, ['is_safe' => ['html']]));
    }

    public static function getRenderer(string $path = "")
    {
        
        if (is_null(self::$renderer)) {
            self::$renderer = new self($path);
        }
       
        return self::$renderer;
    }

    public function addGlobal(string $key, $value)
    {
        $this->twig->addGlobal($key, $value);
         return $this;
    }

    public function addPath(string $path, string $namespace)
    {
        $this->loader->addPath($path."/twig", $namespace) ;
        return $this;
    }

    public function render(string $view, array $param = array()): string
    {
        return  $this->twig->render("$view.twig", $param) ;
    }
}
