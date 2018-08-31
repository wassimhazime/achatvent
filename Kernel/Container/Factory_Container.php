<?php

namespace Kernel\Container;

use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;

class Factory_Container
{

    public static function getContainer(string $pathconfig, string $implementscontainer = "local"): ContainerInterface
    {
         if (!is_file($pathconfig)) {
            throw new TypeError(" erreur path file config ==> $pathconfig  ");
        }
        if ($implementscontainer=="DI") {
             $builder = new ContainerBuilder();
             $builder->addDefinitions($pathconfig);
             $container = $builder->build();
            return $container;
        } else {
            $container = DIC::buildContainer();
            $container->addDefinitions($pathconfig);
            return $container  ;
        }
    }
}
