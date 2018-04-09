<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Parse
 *
 * @author wassime
 */

namespace Kernel\Tools;

use ReflectionClass;

class Tools {

    public static function isAssoc(array $arr): bool {
        if (array() === $arr) {
            return false;
        }
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    public static function entitys_TO_array($object): array {

        return json_decode(json_encode($object), true);
    }

     public static function json($object) {

        return json_encode($object);
    }

    
    public static function parse_object_TO_array($object): array {

        if (is_array($object)) {
            return $object;
        }
        $reflectionClass = new ReflectionClass(get_class($object));
        $array = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($object);
            $property->setAccessible(false);
        }

        return $array;
    }

}
