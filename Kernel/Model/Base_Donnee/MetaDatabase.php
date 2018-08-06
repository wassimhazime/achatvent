<?php

namespace Kernel\Model\Base_Donnee;

use Kernel\Model\Entitys\EntitysSchema;
use Kernel\Tools\Tools;
use TypeError;
use function str_replace;

/**
 * Description of MetaDatabase
 *
 * @author wassime
 */
class MetaDatabase extends ActionDataBase {

    private $is_null = true;
    private $table;
    private $allSchema = [];
    private $schema;

    public function __construct($PathConfigJsone, $table = null) {
        parent::__construct($PathConfigJsone);
        if ($table != null) {
            $this->setTable($table);
        }
    }

    /*
     * ***************************************************************
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |

     */ ///****************************************************************////

    public function is_null(): bool {
        return $this->is_null;
    }

    public function is_Table(string $nameTable): bool {
        $entity = $this->getschema($nameTable);
        return $entity->getNameTable() != null;
    }

    public function getTable(): string {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setTable()");
        }
        return $this->table;
    }

    public function setTable(string $table): bool {
        if ($this->is_Table($table)) {
            $this->is_null = false;
            $this->table = $table;
            $this->schema = $this->getschema($table);
        } else {
            $this->is_null = false;
        }
        return !$this->is_null;
    }

    public function getschema(string $NameTable = ""): EntitysSchema {
        if ($NameTable == "") {
            if ($this->is_null()) {
                throw new TypeError(" set table ==> call function setTable()");
            }
            return $this->schema;
        }
        if ($this->getConfigJson()->is_set_cache()) {
            //generateCache()is null|[] file $path/CACHE_SELECT.JSON
            if ($this->getConfigJson()->getgenerateCACHE_SELECT() == [] || $this->getConfigJson()->getgenerateCACHE_SELECT() == null) {
                $this->generateCache();
            }

            //find json config => model file CACHE_SELECT
            foreach ($this->getConfigJson()->getgenerateCACHE_SELECT() as $table) {
                $TABLE = (new EntitysSchema())->Instance($table);
                if ($TABLE->getNameTable() == $NameTable) {
                    return $TABLE;
                }
            }
            $this->generateCache(); /// is not table donc => modification en data base
        } else {
            $this->getConfigJson()->removeCACHE_SELECT();
        }

        //find json config => model file 2SCHEMA_SELECT_MANUAL
        foreach ($this->getConfigJson()->getSCHEMA_SELECT_MANUAL() as $table) {
            $TABLE = (new EntitysSchema())->Instance($table);
            if ($TABLE->getNameTable() == $NameTable) {
                return $TABLE;
            }
        }
        //find json config => model file 3SCHEMA_SELECT_AUTO

        foreach ($this->getALLschema() as $TABLE) {
            if ($TABLE->getNameTable() == $NameTable) {
                return $TABLE;
            }
        }
        return (new EntitysSchema()); // == return EntitysSchema vide
    }

    public function getAllTables(): array {
        $names_Tables = [];
        $Schemas = $this->getALLschema();
        foreach ($Schemas as $schema) {
            $names_Tables[] = $schema->getNameTable();
        }
        return $names_Tables;
    }

    public function getALLschema(): array {
        $config = $this->getConfigJson()->getSCHEMA_SELECT_AUTO();
        $DB_name = $this->getConfigJson()->getNameDataBase();
        if (empty($this->allSchema)) {
            $allSchema = $this->querySchema(' SELECT table_name as NameTable FROM INFORMATION_SCHEMA.PARTITIONS WHERE TABLE_SCHEMA = "' . $DB_name . '" and  table_name not LIKE("r\_%") ');
            foreach ($allSchema as $table) {
                $table->setCOLUMNS_default($this->columns_default($table, $config));
                $table->setCOLUMNS_master($this->columns_master($table, $config));
                $table->setCOLUMNS_all($this->columns_all($table, $config));
                $table->setCOLUMNS_META($this->columns_META($table, $config));
                $table->setSTATISTIQUE($this->STATISTIQUE($table, $config));
                $table->setFOREIGN_KEY($this->FOREIGN_KEY($table, $config));
                $table->setFILES($this->FILES($table, $config));
                $table->setCHILDREN($this->tables_CHILDREN($table, $config, $DB_name));
            }
            $this->allSchema = $allSchema;
        }
        return $this->allSchema;
    }

    public function getSchemaStatistique($fonction, $alias, $table = "") {
        if ($table == "") {
            $Schemas = $this->getALLschema();
        } else {
            $Schemas = [$this->getschema($table)];
        }
        $schema_statistique = [];
        foreach ($Schemas as $schema) {
            $st = ($schema->select_statistique($fonction, $alias));

            if (!empty($st["select"])) {
                $schema_statistique[$st["table"]] = ["filds" => $st["select"],
                    "GroupBy" => $st["FOREIGN_KEY"]];
            }
        }

        return $schema_statistique;
    }

    //private//////////////////////////////////////////////////////////////////////////

    private function columns_default($table, array $config) {

        $describe = $this->querySimple("SHOW COLUMNS FROM " .
                $table->getNameTable() .
                $config['COLUMNS_default']);

        return $this->getField($describe);
    }

    private function columns_master($table, array $config) {

        $describe = $this->querySimple("SHOW COLUMNS FROM " .
                $table->getNameTable() .
                $config['COLUMNS_master']);

        return $this->getField($describe);
    }

    private function columns_all($table, array $config) {

        $describe = $this->querySimple("SHOW COLUMNS FROM " .
                $table->getNameTable() .
                $config['COLUMNS_all']);

        return $this->getField($describe);
    }

    private function columns_META($table, array $config) {


        $describe = $this->querySchema("  DESCRIBE   " .
                $table->getNameTable());


        return $describe;
    }

    private function columns_master_CHILDREN($table, array $config) {


        $describe = $this->querySimple("SHOW COLUMNS FROM " . $table .
                $config['CHILDREN']['MASTER']);

        return $this->getField($describe);
    }

    private function columns_default_CHILDREN($table, array $config) {


        $describe = $this->querySimple("SHOW COLUMNS FROM " . $table .
                $config['CHILDREN']['DEFAULT']);

        return $this->getField($describe);
    }

    private function columns_all_CHILDREN($table, array $config) {

        $describe = $this->querySimple("SHOW COLUMNS FROM " . $table .
                $config['CHILDREN']['ALL']);



        return $this->getField($describe);
    }

    private function FOREIGN_KEY($table, array $config) {
        if (isset($config['FOREIGN_KEY']) and ! empty($config['FOREIGN_KEY'])) {
            $describe = $this->querySimple("SHOW COLUMNS FROM " .
                    $table->getNameTable() .
                    $config['FOREIGN_KEY']);
        }


        return $this->getField($describe);
    }

    private function FILES($table, array $config) {
        if (isset($config['FILES']) and ! empty($config['FILES'])) {
            $describe = $this->querySimple("SHOW COLUMNS FROM " .
                    $table->getNameTable() .
                    $config['FILES']);
        }


        return $this->getField($describe);
    }

    private function STATISTIQUE($table, array $config) {

        $describe = $this->querySimple("SHOW COLUMNS FROM " .
                $table->getNameTable() .
                $config['STATISTIQUE']);



        return $this->getField($describe);
    }

    private function tables_CHILDREN($mainTable, $config, $DB_name) {

        $tables_relation = $this->querySchema('SELECT table_name as tables_relation FROM'
                . ' INFORMATION_SCHEMA.PARTITIONS WHERE TABLE_SCHEMA = "' . $DB_name . '" '
                . 'and  table_name  LIKE("r\_' . $mainTable->getNameTable() . '\_%")  ');
        $tables_CHILDREN['MASTER'] = [];
        $tables_CHILDREN['ALL'] = [];
        $tables_CHILDREN['DEFAULT'] = [];
        $tables_CHILDREN['EMPTY'] = [];

        foreach ($tables_relation as $champ) {
            $table = str_replace("r_{$mainTable->getNameTable()}_", "", $champ->tables_relation);

            $tables_CHILDREN['MASTER'][$table] = $this->columns_master_CHILDREN($table, $config);
            $tables_CHILDREN['DEFAULT'][$table] = $this->columns_default_CHILDREN($table, $config);
            $tables_CHILDREN['ALL'][$table] = $this->columns_all_CHILDREN($table, $config);
            $tables_CHILDREN['EMPTY'][$table] = [];
        }
        return $tables_CHILDREN;
    }

    /////
    private function getField(array $describe): array {
        $Field = [];
        foreach ($describe as $champ) {
            $Field[] = $champ["Field"];
        }

        return $Field;
    }

    ////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * generateCache
     */
    //////////////////////////////////////
    private function generateCache() {
        $config = $this->getConfigJson();
        $tempschmaTabls = [];
        $schmaTabls = [];
        $DB_AUTO = $this->getALLschema($config->getSCHEMA_SELECT_AUTO());

        foreach ($DB_AUTO as $TABLE) {
            $tempschmaTabls[$TABLE->getNameTable()] = Tools::parse_object_TO_array($TABLE);
        }

        foreach ($config->getSCHEMA_SELECT_MANUAL() as $table) {
            $TABLE = (new EntitysSchema())->Instance($table);
            $tempschmaTabls[$TABLE->getNameTable()] = Tools::parse_object_TO_array($TABLE);
        }

        foreach ($tempschmaTabls as $NameTable => $TABLE) {
            $schmaTabls[] = Tools::parse_object_TO_array($TABLE);
        }



        $config->setgenerateCACHE_SELECT($schmaTabls);
    }

}
