<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Base_Donnee;

use \PDO;
use \PDOException;
use Kernel\Model\Base_Donnee\DataBase;
use core\notify\Notify;

/**
 * Description of RUN
 *
 * @author Wassim Hazime
 */
class RUN extends DataBase
{
    

    protected function query($sql): array
    {
            


        try {
            $Statement = $this->db->query($sql);

            $Statement->setFetchMode(PDO::FETCH_CLASS, get_class($this->entity));


            return $Statement->fetchAll();
        } catch (PDOException $exc) {
            Notify::send_Notify($exc->getMessage() . "querySQL  ERROR ==> </br> $sql");
            die();
        }
    }

    protected function exec($sql): string
    {


        try {
            //$db->beginTransaction();
            $this->db->exec($sql);
            // $db->commit();

            return $this->db->lastInsertId();
        } catch (PDOException $exc) {
            // $db->rollBack();
            Notify::send_Notify($exc->getMessage() . "exec SQL ERROR ==> </br> $sql");
            die();
        }
    }

    // TOOLS

    public static function parse_object_TO_array($object): array
    {
        if (is_array($object)) {
            return $object;
        }
        $reflectionClass = new \ReflectionClass(get_class($object));
        $array = [];
        foreach ($reflectionClass->getProperties() as $property) {
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($object);
            $property->setAccessible(false);
        }
        return $array;
    }
}
