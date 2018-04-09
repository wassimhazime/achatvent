<?php

namespace Kernel\Model\Base_Donnee;

use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Entitys\EntitysSchema;
use PDO;
use PDOException;

class ActionDataBase extends Connection{

  
    

    ////////////////////////////////////////////////////
    /// getData
    protected function query($sql): array {
        try {

            $Statement = $this->db->query($sql);

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
            //$db->beginTransaction();
            $this->db->exec($sql);
            // $db->commit();

            return $this->db->lastInsertId();
        } catch (PDOException $exc) {
            // $db->rollBack();
            //  Notify::send_Notify($exc->getMessage() . "exec SQL ERROR ==> </br> $sql");
            echo $exc->getMessage();
            echo '<br><hr>';
            die($sql);
        }
    }

    /// getShema
    protected function querySchema($sql): array {

        try {

            $Statement = $this->db->query($sql);

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
