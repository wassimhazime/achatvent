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

use Kernel\INTENT\Intent;
use ReflectionClass;

class Tools {

    public static function intent_to_metaTableHTML(Intent $intent) {
        $schema = $intent->getEntitysSchema();
        $COLUMNS_master = $schema->getCOLUMNS_master();
        $COLUMNS_all = $schema->getCOLUMNS_all();
        $COLUMNS_default = $schema->getCOLUMNS_default();
        $FOREIGN_KEY = $schema->getFOREIGN_KEY();
        $entitysDataTable = $intent->getEntitysDataTable();

        if (Intent::is_show_MASTER($intent)) {
            $columns = array_merge($COLUMNS_master, $FOREIGN_KEY);
        } elseif (Intent::is_show_ALL($intent)) {
            $columns = array_merge($COLUMNS_all, $FOREIGN_KEY);
        } elseif (Intent::is_show_DEFAULT($intent)) {
            $columns = array_merge($COLUMNS_default, $FOREIGN_KEY);
        }
        $CHILD = [];
        $CHILD["flag_show_CHILDREN"] = Intent::is_get_CHILDREN($intent);

        if ($CHILD["flag_show_CHILDREN"]) {
            $CHILD["table_CHILDREN"] = $schema->get_table_CHILDREN(); // le nom de la table
            $CHILD["CHILDREN"] = $schema->getCHILDREN(); // les noms des champ
            $CHILD["datajoins"] = [];  //// body
            foreach ($entitysDataTable as $entity) {
                $CHILD["datajoins"][] = $entity->getDataJOIN();
            }

            $columns = array_merge($columns, $CHILD["table_CHILDREN"]);  ///head
        }
        $DataTable = Tools::entitys_TO_array($entitysDataTable);
        return ["columns" => $columns, "DataTable" => $DataTable, "CHILD" => $CHILD];
    }

    public static function date_FR_to_EN($var) {

        $date = str_replace('/', '-', $var);
        return date('Y-m-d', strtotime($date));
    }

    public static function date_EN_to_FR($var) {

        $date = str_replace('-', '/', $var);
        return date('d/m/Y', strtotime($date));
    }

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
