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
            if (!empty($entitysDataTables) and ! $this->isAssoc($entitysDataTables)) {
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

  

    /// insert Statement
    public static function parse(array $data, EntitysSchema $schema, array $mode): self
    {

        if (self::isAssoc($data) and isset($data)) {
            return (new self($schema, ((new EntitysDataTable())->set($data)), $mode));
        }
    }

    public static function entitys_TO_array($object): array
    {

        return json_decode(json_encode($object), true);

        if (is_array($object)) {
            return $object;
        }
        $array = [];
        foreach ($object as $key => $value) {
            $array[$key] = $value;
        }
        return $array;
    }
    
    //TOOLS
    //// for show Statement
    public static function is_PARENT_MASTER($_intentORmode): bool
    {
        if ($_intentORmode instanceof Intent) {
            $mode = $_intentORmode->getMode();
        } else {
            $mode = $_intentORmode;
        }

        return $mode[0] == "MASTER";
    }

    public static function is_PARENT_ALL($_intentORmode): bool
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

    public static function isAssoc(array $arr): bool
    {
        if (array() === $arr) {
            return false;
        }
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
