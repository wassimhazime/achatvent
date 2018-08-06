<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Base_Donnee;

use Exception;
use Kernel\Model\Base_Donnee\ConfigExternal;
use PDO;

/**
 * Description of Connection
 * snglton class
 *
 * @author wassime
 */
class Connection {

    private $configExternal;
    private static $init = [];
    private $db;

    private static function getInit(string $PathConfigJson) {
        if (self::$init === []) {
            $configExternal = new ConfigExternal($PathConfigJson);
            $configPDO = $configExternal->getConnect();
            $DB = $configPDO['DB'];
            $dbhost = $configPDO['dbhost'];
            $dbuser = $configPDO['dbuser'];
            $dbpass = $configPDO['dbpass'];
            $dbname = $configPDO['dbname'];
            try {
                self::$init["configExternal"] = $configExternal;
                self::$init["PDO"] = new PDO("$DB:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            } catch (Exception $e) {
                
                die('Erreur data base: ' . $e->getMessage());
            }
        }

        return self::$init;
    }

    public function __construct(string $PathConfigJson) {
        $init = self::getInit($PathConfigJson);
        $this->db = $init['PDO'];
        $this->configExternal = $init['configExternal'];
    }

    public function getDatabase(): PDO {
        return $this->db;
    }

    public function getConfigJson(): ConfigExternal {
        return $this->configExternal;
    }

}
