<?php

namespace Kernel\Model\Base_Donnee;

use Kernel\Model\Base_Donnee\Connection;
use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Entitys\EntitysSchema;
use Kernel\Model\Query\Prepare;
use \PDO;
use \PDOException;

class ActionDataBase extends Connection {

    ///////////////////////////////////////////////////
    /// getData
    protected function prepareQuery(Prepare $query) {

        $sqlprepare = $query->getPrepare();
        $params_execute = $query->getExecute();

        try {
            $Statement = $this->getDataBase()->prepare($sqlprepare);
            $Statement->execute($params_execute);
            $Statement->setFetchMode(\PDO::FETCH_CLASS, EntitysDataTable::class);
            $results = $Statement->fetchAll();

            return $results;
        } catch (\PDOException $exc) {
            //    Notify::send_Notify($exc->getMessage() . "querySQL  ERROR ==> </br> $sql");
            echo $exc->getMessage();
            die($sqlprepare);
        }
    }

    protected function query(string $sql): array {

        try {
            $Statement = $this->getDataBase()->query($sql);
            $Statement->setFetchMode(\PDO::FETCH_CLASS, EntitysDataTable::class);
            return $Statement->fetchAll();
        } catch (\PDOException $exc) {
            //    Notify::send_Notify($exc->getMessage() . "querySQL  ERROR ==> </br> $sql");
            echo $exc->getMessage();
            echo '<br><hr>';
            die($sql);
        }
    }

    /// setdata
    protected function prepareQueryEXEC(Prepare $query) {

        $sqlprepare = $query->getPrepare();
        $params_execute = $query->getExecute();

        try {
            $Statement = $this->getDataBase()->prepare($sqlprepare);
            $Statement->execute($params_execute);
            return $this->getDataBase()->lastInsertId();
        } catch (\PDOException $exc) {
            //    Notify::send_Notify($exc->getMessage() . "querySQL  ERROR ==> </br> $sql");
            echo $exc->getMessage();
            die();
        }
    }

    protected function exec($sql): string {
        var_dump($sql);
    

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
        } catch (\PDOException $exc) {
            //    Notify::send_Notify($exc->getMessage() . "querySQL  ERROR ==> </br> $sql");
            echo $exc->getMessage();
            echo '<br><hr>';
            die($sql);
        }
    }

}
