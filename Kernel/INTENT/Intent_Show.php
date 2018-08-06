<?php

namespace Kernel\INTENT;

use Kernel\Model\Entitys\EntitysSchema;
use Kernel\Model\Entitys\EntitysDataTable;

class Intent_Show extends Intent {

    const MODE_SELECT_DEFAULT_DEFAULT = ["DEFAULT", "DEFAULT"];
    const MODE_SELECT_DEFAULT_MASTER = ["DEFAULT", "MASTER"];
    const MODE_SELECT_DEFAULT_ALL = ["DEFAULT", "ALL"];
    const MODE_SELECT_MASTER_DEFAULT = ["MASTER", "DEFAULT"];
    const MODE_SELECT_MASTER_MASTER = ["MASTER", "MASTER"];
    const MODE_SELECT_MASTER_ALL = ["MASTER", "ALL"];
    const MODE_SELECT_ALL_DEFAULT = ["ALL", "DEFAULT"];
    const MODE_SELECT_ALL_MASTER = ["ALL", "MASTER"];
    const MODE_SELECT_ALL_ALL = ["ALL", "ALL"];
    const MODE_SELECT_DEFAULT_NULL = ["DEFAULT", "EMPTY"];
    const MODE_SELECT_MASTER_NULL = ["MASTER", "EMPTY"];
    const MODE_SELECT_ALL_NULL = ["ALL", "EMPTY"];

    function __construct($entitysSchema, $entitysDataTables, $mode) {

        foreach ($entitysDataTables as $entitysDataTable) {
            if ($entitysDataTable instanceof EntitysDataTable) {
                
            } else {
                throw new TypeError("type array entre ERROR ==> EntitysDataTable mode:: MODE_SELECT ");
            }
        }

        parent::__construct($entitysSchema, $entitysDataTables, $mode);
    }

    //TOOLS
    //// for show 
    public static function is_show_DEFAULT($_intentORmode): bool {
        if ($_intentORmode instanceof Intent) {
            $mode = $_intentORmode->getMode();
        } else {
            $mode = $_intentORmode;
        }

        return $mode[0] == "DEFAULT";
    }

    public static function is_show_MASTER($_intentORmode): bool {
        if ($_intentORmode instanceof Intent) {
            $mode = $_intentORmode->getMode();
        } else {
            $mode = $_intentORmode;
        }

        return $mode[0] == "MASTER";
    }

    public static function is_show_ALL($_intentORmode): bool {
        if ($_intentORmode instanceof Intent) {
            $mode = $_intentORmode->getMode();
        } else {
            $mode = $_intentORmode;
        }
        return $mode[0] == "ALL";
    }

    public static function is_get_CHILDREN($_intentORmode): bool {
        if ($_intentORmode instanceof Intent) {
            $mode = $_intentORmode->getMode();
        } else {
            $mode = $_intentORmode;
        }
        return $mode[1] != "EMPTY";
    }

}
