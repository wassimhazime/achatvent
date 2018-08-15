<?php

namespace Kernel\Model\Base_Donnee;

use Kernel\AWA_Interface\Base_Donnee\ActionDataBaseInterface;
use Kernel\Model\Base_Donnee\Connection;
use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Entitys\EntitysSchema;
use Kernel\Model\Query\Prepare;
use PDO;
use PDOException;

class ActionDataBase extends Connection implements ActionDataBaseInterface {

    /**
     * get Shema form EntitysSchema
     * array de EntitysSchema
     * @param string $sql
     * @return array 
     */
    public function querySchema(string $sql): array {

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

    /**
     * get data form EntitysDataTable
     * @param string $sql
     * @return array EntitysDataTable
     */
    public function query(string $sql): array {

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

    /**
     * // get data form EntitysDataTable avec style prepare
     * @param Prepare $query
     * @return array EntitysDataTable
     */
    public function prepareQuery(Prepare $query): array {

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

    /**
     * // get data form array assoc avec style prepare
     * @param Prepare $query
     * @return array Assoc
     */
    public function prepareQueryAssoc(Prepare $query): array {
        $sqlprepare = $query->getPrepare();
        $params_execute = $query->getExecute();

        try {
            $Statement = $this->getDataBase()->prepare($sqlprepare);
            $Statement->execute($params_execute);
            $Statement->setFetchMode(PDO::FETCH_ASSOC);
            $results = $Statement->fetchAll();

            return $results;
        } catch (\PDOException $exc) {
            //    Notify::send_Notify($exc->getMessage() . "querySQL  ERROR ==> </br> $sql");
            echo $exc->getMessage();
            die($sqlprepare);
        }
    }

    /**
     * / get data form array assoc 
     * @param string $sql
     * @return array assoc
     */
    public function querySimple(string $sql): array {

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

    /**
     * sql simple
     * @param string $sql
     * @return int
     */
    public function exec(string $sql): int {



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

    /**
     * sql prepare
     * @param Prepare $query
     * @return int
     */
    public function prepareEXEC(Prepare $query): int {

        $sqlprepare = $query->getPrepare();
        $params_execute = $query->getExecute();

        try {
            $Statement = $this->getDataBase()->prepare($sqlprepare);
            $Statement->execute($params_execute);
            return $this->getDataBase()->lastInsertId();
        } catch (\PDOException $exc) {
            //    Notify::send_Notify($exc->getMessage() . "querySQL  ERROR ==> </br> $sql");
            //     echo $exc->getMessage();
            return -1;
        }
    }

}
