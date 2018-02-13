<?php

namespace Kernel\Model\Base_Donnee;

use Kernel\Model\Base_Donnee\RUN;
use Kernel\Model\Entitys\EntitysSchema;

class Schema extends RUN
{

    private $PARENT = null;
    private $pathConfigJsone;

    function __construct($pathConfigJsone)
    {
        $this->pathConfigJsone = $pathConfigJsone;
        parent::__construct($pathConfigJsone, new EntitysSchema()); /// pour setFetchMode(PDO::FETCH_CLASS, get_class($this->entity));
    }

    public function getschema(string $parent): EntitysSchema
    {

        if ($this->configExternal->is_set_cache()) {
            //generateCache()is null|[] file $path/CACHE_SELECT.JSON
            if ($this->configExternal->getgenerateCACHE_SELECT() == [] || $this->configExternal->getgenerateCACHE_SELECT() == null) {
                $this->generateCache();
            }

            //find json config => model file CACHE_SELECT
            foreach ($this->configExternal->getgenerateCACHE_SELECT() as $table) {
                $TABLE = (new EntitysSchema())->Instance($table);
                if ($TABLE->getPARENT() == $parent) {
                    return $TABLE;
                }
            }
            $this->generateCache(); /// is not table donc => modification en data base
        } else {
            $this->configExternal->removeCACHE_SELECT();
        }






        //find json config => model file 2SCHEMA_SELECT_MANUAL
        foreach ($this->configExternal->getSCHEMA_SELECT_MANUAL() as $table) {
            $TABLE = (new EntitysSchema())->Instance($table);
            if ($TABLE->getPARENT() == $parent) {
                return $TABLE;
            }
        }
        //find json config => model file 3SCHEMA_SELECT_AUTO
        //and system SCHEMA_SELECT_AUTO
        foreach ($this->getALLschema($this->configExternal->getSCHEMA_SELECT_AUTO()) as $TABLE) {
            if ($TABLE->getPARENT() == $parent) {
                return $TABLE;
            }
        }


        return (new EntitysSchema()); // == return EntitysSchema vide
    }

    public function getALLschema(array $config = []): array
    {
        $DB_name = $this->configExternal->getNameDataBase();
        if ($this->PARENT == null) {
            $PARENT = $this->query(' SELECT table_name as PARENT FROM INFORMATION_SCHEMA.PARTITIONS WHERE TABLE_SCHEMA = "' . $DB_name . '" and  table_name not LIKE("r\_%") ');
            foreach ($PARENT as $table) {
                $table->setCOLUMNS_master($this->columns_master($table, $config));
                $table->setCOLUMNS_all($this->columns_all($table, $config));
                $table->setCOLUMNS_META($this->columns_META($table, $config));
                $table->setFOREIGN_KEY($this->FOREIGN_KEY($table, $config));
                $table->setCHILDREN($this->tables_CHILDREN($table, $config, $DB_name));
            }
            $this->PARENT = $PARENT;
        }
        return $this->PARENT;
    }

    //private//////////////////////////////////////////////////////////////////////////
    private function columns_master($table, array $config = [])
    {
        if (isset($config['COLUMNS_master']) and ! empty($config['COLUMNS_master'])) {
            $describe = $this->query("SHOW COLUMNS FROM " .
                    $table->getPARENT() .
                    $config['COLUMNS_master']);
        } else {
            $describe = $this->query("SHOW COLUMNS FROM " .
                    $table->getPARENT() .
                    " WHERE `null`='no' and "
                    . "`Type` !='varchar(201)' and"
                    . " `Type` !='varchar(20)' and "
                    . "`Key`!='MUL' ");
        }


        $select = [];

        foreach ($describe as $champ) {
            $select[] = $champ->Field;
        }
        return $select;
    }

    private function columns_all($table, array $config = [])
    {
        if (isset($config['COLUMNS_all']) and ! empty($config['COLUMNS_all'])) {
            $describe = $this->query("SHOW COLUMNS FROM " .
                    $table->getPARENT() .
                    $config['COLUMNS_all']);
        } else {
            $describe = $this->query("SHOW COLUMNS FROM " .
                    $table->getPARENT() .
                    " WHERE "
                    . "`Key`!='MUL' ");
        }


        $select = [];

        foreach ($describe as $champ) {
            $select[] = $champ->Field;
        }
        return $select;
    }

    private function columns_META($table, array $config = [])
    {

        if (isset($config['COLUMNS_META']) and ! empty($config['COLUMNS_META'])) {
            $describe = $this->query("  DESCRIBE   " .
                    $table->getPARENT());
        } else {
            $describe = $this->query("  DESCRIBE   " .
                    $table->getPARENT());
        }

        return $describe;
    }

    private function columns_master_CHILDREN($table, array $config = [])
    {

        if (isset($config['CHILDREN']['MASTER']) and ! empty($config['CHILDREN']['MASTER'])) {
            $describe = $this->query("SHOW COLUMNS FROM " . $table .
                    $config['CHILDREN']['MASTER']);
        } else {
            $describe = $this->query("SHOW COLUMNS FROM " . $table .
                    " WHERE `null`='no' and "
                    . "`Type` !='varchar(201)' and"
                    . " `Type` !='varchar(20)' and"
                    . "`Key`!='MUL' ");
        }


        $colums = [];
        if (!empty($describe) or $describe != null) {
            foreach ($describe as $colum) {
                $colums[] = $colum->Field;
            }
        }

        return $colums;
    }

    private function columns_all_CHILDREN($table, array $config = [])
    {
        if (isset($config['CHILDREN']['ALL']) and ! empty($config['CHILDREN']['ALL'])) {
            $describe = $this->query("SHOW COLUMNS FROM " . $table .
                    $config['CHILDREN']['ALL']);
        } else {
            $describe = $this->query("SHOW COLUMNS FROM " . $table .
                    " WHERE "
                    . "`Key`!='MUL' ");
        }


        $colums = [];
        if (!empty($describe) or $describe != null) {
            foreach ($describe as $colum) {
                $colums[] = $colum->Field;
            }
        }

        return $colums;
    }

    private function FOREIGN_KEY($table, array $config = [])
    {
        if (isset($config['FOREIGN_KEY']) and ! empty($config['FOREIGN_KEY'])) {
            $describe = $this->query("SHOW COLUMNS FROM " .
                    $table->getPARENT() .
                    $config['FOREIGN_KEY']);
        } else {
            $describe = $this->query("SHOW COLUMNS FROM " .
                    $table->getPARENT() .
                    " WHERE `Key`='MUL'");
        }


        $FOREIGN_KEY = [];

        foreach ($describe as $champ) {
            $FOREIGN_KEY[] = $champ->Field;
        }
        return $FOREIGN_KEY;
    }

    private function tables_CHILDREN($mainTable, $config, $DB_name)
    {
        $tables_relation = (new self($this->pathConfigJsone))->query('SELECT table_name as tables_relation FROM'
                . ' INFORMATION_SCHEMA.PARTITIONS WHERE TABLE_SCHEMA = "' . $DB_name . '" '
                . 'and  table_name  LIKE("r\_' . $mainTable->getPARENT() . '%")  ');
        $tables_CHILDREN['MASTER'] = [];
        $tables_CHILDREN['ALL'] = [];
        $tables_CHILDREN['EMPTY'] = [];

        foreach ($tables_relation as $champ) {
            $table = str_replace("r_{$mainTable->getPARENT()}_", "", $champ->tables_relation);

            $tables_CHILDREN['MASTER'][$table] = (new self($this->pathConfigJsone))->columns_master_CHILDREN($table, $config);
            $tables_CHILDREN['ALL'][$table] = (new self($this->pathConfigJsone))->columns_all_CHILDREN($table, $config);
            $tables_CHILDREN['EMPTY'][$table] = [];
        }
        return $tables_CHILDREN;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * generateCache
     */
    //////////////////////////////////////
    private function generateCache()
    {
        $config = $this->configExternal;
        $tempschmaTabls = [];
        $schmaTabls = [];
        $DB_AUTO = $this->getALLschema($config->getSCHEMA_SELECT_AUTO());

        foreach ($DB_AUTO as $TABLE) {
            $tempschmaTabls[$TABLE->getPARENT()] = self::parse_object_TO_array($TABLE);
        }

        foreach ($config->getSCHEMA_SELECT_MANUAL() as $table) {
            $TABLE = (new EntitysSchema())->Instance($table);
            $tempschmaTabls[$TABLE->getPARENT()] = self::parse_object_TO_array($TABLE);
        }

        foreach ($tempschmaTabls as $PARENT => $TABLE) {
            $schmaTabls[] = self::parse_object_TO_array($TABLE);
        }



        $config->setgenerateCACHE_SELECT($schmaTabls);
    }
}
