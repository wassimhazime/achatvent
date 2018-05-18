<?php

namespace Kernel\Model\Base_Donnee;

use Kernel\Model\Base_Donnee\Connection;
use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Entitys\EntitysSchema;
use \PDO;
use \PDOException;

class ActionDataBase extends Connection {

    ///////////////////////////////////////////////////


    protected function prepareQuerySQL(array $query) {
        $sqlprepare = $query["prepare"];
        $params_execute = $query["execute"];



        /* Exécute une requête préparée en passant un tableau de valeurs */
        var_dump($sqlprepare, $params_execute);
        try {
            $p = $this->getDataBase()->prepare($sqlprepare);
            $p->execute($params_execute);
        } catch (\PDOException $exc) {
            //    Notify::send_Notify($exc->getMessage() . "querySQL  ERROR ==> </br> $sql");
            echo $exc->getMessage();
            die();
         
        }
        return $this->getDataBase()->lastInsertId();
    }

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
        var_dump($sql);
        echo 'errrrr <br><hr>';
        die($sql);

        try {
            //$getDataBase()->beginTransaction();

            $this->getDataBase()->exec($sql);
            // $getDataBase()->commit();

            return $this->getDataBase()->lastInsertId();
        } catch (PDOException $exc) {
            // $getDataBase()->rollBack();
            //  Notify::send_Notify($exc->getMessage() . "exec SQL ERROR ==> </br> $sql");
            echo $exc->getMessage();
            echo 'errrrr <br><hr>';
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

    /// getShema
    protected function querySimple($sql): array {

        try {
            $Statement = $this->getDataBase()->query($sql);

            $Statement->setFetchMode(PDO::FETCH_ASSOC);
            return $Statement->fetchAll();
        } catch (PDOException $exc) {
            //    Notify::send_Notify($exc->getMessage() . "querySQL  ERROR ==> </br> $sql");
            echo $exc->getMessage();
            echo '<br><hr>';
            die($sql);
        }
    }

}
