<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Base_Donnee;

use Exception;
use Kernel\AWA_Interface\Base_Donnee\ConnectionInterface;
use Kernel\File\File;
use PDO;
use TypeError;

/**
 * Description of Connection
 * snglton class
 *
 * @author wassime
 */
class Connection implements ConnectionInterface {

    const File_Connect_DataBase = "Connect_DataBase";
    const BOOT = "BOOT";
    const cache = "cache";
    const dbname = "dbname";

    private static $fileConfigDB;
    
    private static $ConfigDB;
    private static $PDO = null;

    /**
     * singlton
     * @param string $PathConfigJson
     * @return PDO
     */
    public static function getPDO(string $PathConfigJson): PDO {
        if (self::$PDO === null) {

        
            $file = new File($PathConfigJson, File::JSON, []);

            self::setFileConfigDB($file);

            $config = self::getFileConfigDB(self::File_Connect_DataBase);
            self::setConfigDB($config);

            $DB = self::getConfigDB('DB');
            $dbhost = self::getConfigDB('dbhost');
            $dbuser = self::getConfigDB('dbuser');
            $dbpass = self::getConfigDB('dbpass');
            $dbname = self::getConfigDB('dbname');
            try {

                self::$PDO = new PDO("$DB:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (Exception $e) {

                die('Erreur data base: ' . $e->getMessage());
            }
        }

        return self::$PDO;
    }

    /**
     * data config file
     * @param string $key
     * @return array|string
     */
    static function getConfigDB(string $key = "") {
        if ($key == "") {
            return self::$ConfigDB;
        } else {
            return self::$ConfigDB[$key];
        }
    }

    /**
     *
     * @param string $PathConfigJson
     */
    public function __construct($PathConfigJson, $table = null) {
        self::getPDO($PathConfigJson);
    }

    /**
     * singlton
     * @return PDO
     */
    public function getDatabase(): PDO {

        return self::$PDO;
    }

    /**
     * 
     * @param string $key
     * @return type File | array
     */
    static function getFileConfigDB(string $key = "", string $type = File::JSON) {

        if ($key == "") {
            return self::$fileConfigDB;
        } else {
            return self::$fileConfigDB->get($key, $type);
        }
    }

    /**
     * 
     * @param File $fileConfigDB
     */
    static function setFileConfigDB(File $fileConfigDB) {
        self::$fileConfigDB = $fileConfigDB;
    }

    /**
     * 
     * @param array $config
     * @throws TypeError
     */
    static function setConfigDB(array $config) {
        if (empty($config)) {
            throw new TypeError(" erreur file config dataBase json or path ");
        }
        self::$ConfigDB = $config[$config[self::BOOT]];
    }

}
