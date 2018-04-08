<?php

namespace Kernel\Model\Base_Donnee;

use \PDO;
use \Exception;
use core\notify\Notify;
use Kernel\Model\Entitys\abstractEntitys;
use Kernel\Model\Base_Donnee\ConfigExternal;
use Kernel\Model\Entitys\EntitysSchema;

class DataBase {

    protected $db;
    protected $entitysSchema;
    protected $entity;
    protected $configExternal;
    private static $dbConnection = null;

    private static function getDB(array $config) {

        if (self::$dbConnection === null) {
            $DB = $config['DB'];
            $dbhost = $config['dbhost'];
            $dbuser = $config['dbuser'];
            $dbpass = $config['dbpass'];
            $dbname = $config['dbname'];
           try {
               
                self::$dbConnection = new PDO("$DB:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (Exception $e) {
                Notify::send_Notify($e->getMessage());
              die('Erreur data base: ' . $e->getMessage());
            }
           
        }

        return self::$dbConnection;
    }

    public function __construct(string $PathConfigJsone, abstractEntitys $entity, EntitysSchema $entitysSchema = null) {

        $this->configExternal = new ConfigExternal($PathConfigJsone);
        $this->db = DataBase::getDB($this->configExternal->getConnect());
        
        $this->entitysSchema = $entitysSchema;
        $this->entity = $entity;
    }

    
    
    ////////////////////////////////////////////////////
    /// getData
    protected function query($sql): array {
try {

            $Statement = $this->db->query($sql);

            $Statement->setFetchMode(PDO::FETCH_CLASS, get_class($this->entity));



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
    ////////////////////////////////////////////////////////
    
    
   
    /*
     * schem data base
     * 
     * 
     * 
     */

}
