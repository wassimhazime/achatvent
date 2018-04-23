<?php

namespace Kernel\Container;

use Psr\Container\ContainerInterface;
use DI\ContainerBuilder;

class Factory_Container
{

    public static function getContainer(string $config, string $implementscontainer = "local"): ContainerInterface
    {
        if ($implementscontainer=="DI") {
             $builder = new ContainerBuilder();
             $builder->addDefinitions($config);
             $container = $builder->build();
            return $container;
        } else {
            $container = DIC::buildContainer();
            $container->addDefinitions($config);
            return $container  ;
        }
    }
}
