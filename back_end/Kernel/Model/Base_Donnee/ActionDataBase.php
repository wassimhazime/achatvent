<?php

namespace Kernel\Model\Base_Donnee;

use Kernel\Model\Base_Donnee\Connection;
use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Entitys\EntitysSchema;
use \PDO;

class ActionDataBase extends Connection {

    ///////////////////////////////////////////////////
    /// getData
    protected function query($sql): array {
        try {

            $Statement = $this->getDataBase()->query($sql);

            $Statement->setFetchMode(PDO::FETCH_CLASS, EntitysDataTable::class);
            return $Statement->fetchAll();
        } catch (PDOException $exc) {
            //    Notify::send_Notify($exc->getMessage() . "querySQL  ERROR ==> </br> $sql");
            echo $exc->getMessage();
            echo '<br><hr>';
            die($sql);
        }
    }

    /// setdata
    protected function exec($sql): string {


        try {
            //$getDataBase()->beginTransaction();
            $this->getDataBase()->exec($sql);
            // $getDataBase()->commit();

            return $this->getDataBase()->lastInsertId();
        } catch (PDOException $exc) {
            // $getDataBase()->rollBack();
            //  Notify::send_Notify($exc->getMessage() . "exec SQL ERROR ==> </br> $sql");
            echo $exc->getMessage();
            echo '<br><hr>';
            die($sql);
        }
    }

    /// getShema
    protected function querySchema($sql): array {

        try {

            $Statement = $this->getDataBase()->query($sql);

            $Statement->setFetchMode(PDO::FETCH_CLASS, EntitysSchema::class);
            return $Statement->fetchAll();
        } catch (PDOException $exc) {
            //    Notify::send_Notify($exc->getMessage() . "querySQL  ERROR ==> </br> $sql");
            echo $exc->getMessage();
            echo '<br><hr>';
            die($sql);
        }
    }

    ////////////////////////////////////////////////////////
}
