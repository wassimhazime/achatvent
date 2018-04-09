<?php

namespace Kernel\INTENT;

use Kernel\Model\Entitys\EntitysSchema;
use Kernel\Model\Entitys\EntitysDataTable;

class Intent
{

    const MODE_SELECT_MASTER_MASTER = ["MASTER", "MASTER"];
    const MODE_SELECT_MASTER_ALL = ["MASTER", "ALL"];
    const MODE_SELECT_ALL_MASTER = ["ALL", "MASTER"];
    const MODE_SELECT_ALL_ALL = ["ALL", "ALL"];
    const MODE_SELECT_MASTER_NULL = ["MASTER", "EMPTY"];
    const MODE_SELECT_ALL_NULL = ["ALL", "EMPTY"];
    const MODE_INSERT = ["INSERT"];
    const MODE_UPDATE = ["UPDATE"];
    const MODE_FORM = ["FORM"];

    //const MODE_FORM_ADMIN = ["FORM"];

    private $entitysSchema;
    private $entitysDataTable;
    private $mode;

    public function __construct(EntitysSchema $entitysSchema, array $entitysDataTables, array $mode)
    {
        $this->mode = $mode;
        if ($mode == self::MODE_FORM) {
            if (!empty($entitysDataTables) and ! \Kernel\Tools\Tools::isAssoc($entitysDataTables)) {
                throw new \TypeError("type array entre ERROR ==> EntitysDataTable de FOREIGN KEY mode:: MODE_FORM");
            }
        } else {
            foreach ($entitysDataTables as $entitysDataTable) {
                if ($entitysDataTable instanceof EntitysDataTable) {
                } else {
                    throw new \TypeError("type array entre ERROR ==> EntitysDataTable mode:: MODE_SELECT ");
                }
            }
        }



        $this->entitysSchema = $entitysSchema;
        $this->entitysDataTable = $entitysDataTables;
    }

    public function getEntitysSchema(): EntitysSchema
    {
        return $this->entitysSchema;
    }

    public function getEntitysDataTable()
    {
        return $this->entitysDataTable;
    }

    public function getMode(): array
    {
        return $this->mode;
    }

  

     // TOOLS
/// plus

    
    //TOOLS
    //// for show Statement
    public static function is_NameTable_MASTER($_intentORmode): bool
    {
        if ($_intentORmode instanceof Intent) {
            $mode = $_intentORmode->getMode();
        } else {
            $mode = $_intentORmode;
        }

        return $mode[0] == "MASTER";
    }

    public static function is_NameTable_ALL($_intentORmode): bool
    {
        if ($_intentORmode instanceof Intent) {
            $mode = $_intentORmode->getMode();
        } else {
            $mode = $_intentORmode;
        }
        return $mode[0] == "ALL";
    }

    public static function is_get_CHILDREN($_intentORmode): bool
    {
        if ($_intentORmode instanceof Intent) {
            $mode = $_intentORmode->getMode();
        } else {
            $mode = $_intentORmode;
        }
        return $mode[1] != "EMPTY";
    }

  
}
