<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Base_Donnee;

use core\notify\Notify;
use Exception;
use Kernel\Model\Base_Donnee\ConfigExternal;
use PDO;

/**
 * Description of Connection
 *
 * @author wassime
 */
class Connection
{

    protected $configExternal;
    private static $dbConnection = null;
    
    private $db;

    private static function getDB(array $config)
    {

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

    // private $pathConfigJsone;
    public function __construct(string $PathConfigJsone)
    {
        // $this->pathConfigJsone = $PathConfigJsone;
        $this->configExternal = new ConfigExternal($PathConfigJsone);
        $this->db = self::getDB($this->configExternal->getConnect());
    }
      
    protected function getDatabase()
    {
      
        return $this->db;
    }
}
