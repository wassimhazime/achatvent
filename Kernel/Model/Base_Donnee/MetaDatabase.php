<?php

namespace Kernel\Model\Base_Donnee;

use Kernel\AWA_Interface\Base_Donnee\MetaDatabaseInterface;
use Kernel\Model\Entitys\EntitysSchema;
use Kernel\Tools\Tools;
use TypeError;
use function str_replace;

/**
 * Description of MetaDatabase
 *
 * @author wassime
 */
class MetaDatabase extends ActionDataBase implements MetaDatabaseInterface {

    const SCHEMA_SELECT_MANUAL = "SCHEMA_SELECT_MANUAL";
    const SCHEMA_SELECT_AUTO = "SCHEMA_SELECT_AUTO";
    const CACHE_SELECT = "SCHEMA_SELECT_CACHE";

    private static $allSchema = [];
    protected $schema;
    private $is_null = true;
    private $table;

    /**
     * 
     * @param type $PathConfigJsone
     * @param type $table
     */
    public function __construct($PathConfigJsone, $table = null) {
        parent::__construct($PathConfigJsone);
        if ($table != null) {
            $this->setTable($table);
        }
    }

    /**
     * is not table to data base
     * @return bool
     */
    public function is_null(): bool {
        return $this->is_null;
    }

    /**
     * has in table to data base
     * @param string $nameTable
     * @return bool
     */
    public function is_Table(string $nameTable): bool {
        if ($nameTable == "") {
            return false;
        }
        $entity = $this->getschema($nameTable);
        return $entity->getNameTable() != null;
    }

    /**
     * has in table to data base
     * @param string $nameTable
     * @return bool
     */
    public function has_Table(string $nameTable): bool {
        return $this->is_Table($nameTable);
    }

    /**
     * get name table set connect
     * @return string
     * @throws TypeError
     */
    public function getTable(): string {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setTable()");
        }
        return $this->table;
    }

    /**
     * set name table connect
     * @param string $table
     * @return bool
     */
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

    /**
     * get EntitysSchema de  table par name table
     * @param string|"" $NameTable
     * @return EntitysSchema
     * @throws TypeError
     */
    public function getschema(string $NameTable = ""): EntitysSchema {
        if ($NameTable == "") {
            if ($this->is_null()) {
                throw new TypeError(" set table ==> call function setTable()");
            }
            return $this->schema;
        }


        foreach ($this->getALLschema() as $Schema) {
            if ($Schema->getNameTable() == $NameTable) {
                return $Schema;
            }
        }

        return (new EntitysSchema()); // == return EntitysSchema vide
    }

    /**
     * get tous les names tables  data base
     * @return array string
     */
    public function getAllTables(): array {
        $names_Tables = [];
        $Schemas = $this->getALLschema();
        foreach ($Schemas as $schema) {
            $names_Tables[] = $schema->getNameTable();
        }
        return $names_Tables;
    }

    /**
     * get tous les schemas tables  data base
     * @return array
     * @throws TypeError
     */
    public function getALLschema(): array {

        if (empty(self::$allSchema)) {
            $this->getALLschema_cache();
            $this->getALLschema_manule();
            $this->getALLschema_auto();
            if (empty(self::$allSchema)) {
                throw new TypeError(" "
                . "erreur getALLschema =>> show json config | "
                . "SCHEMA_SELECT_MANUAL"
                . "SCHEMA_SELECT_AUTO"
                . "SCHEMA_SELECT_CACHE");
            }

            if (self::is_set_cache()) {
                if (empty(self::getgenerateCACHE_SELECT())) {
                    $this->generateCache();
                }
            } else {
                self::removeCACHE_SELECT();
            }
        }
        return self::$allSchema;
    }

    /**
     * getSchemaStatistique
     * @param type $fonction
     * @param type $alias
     * @param type $table
     * @return type
     */
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
    /**
     * get schema auto
     * @param type $table
     * @param array $config
     * @return type
     */
    private function columns_default($table, array $config) {

        $describe = $this->querySimple("SHOW COLUMNS FROM " .
                $table->getNameTable() .
                $config['COLUMNS_default']);

        return $this->getField($describe);
    }

    /**
     * get schema auto
     * @param type $table
     * @param array $config
     * @return type
     */
    private function columns_master($table, array $config) {

        $describe = $this->querySimple("SHOW COLUMNS FROM " .
                $table->getNameTable() .
                $config['COLUMNS_master']);

        return $this->getField($describe);
    }

    /**
     * get schema auto
     * @param type $table
     * @param array $config
     * @return type
     */
    private function columns_all($table, array $config) {

        $describe = $this->querySimple("SHOW COLUMNS FROM " .
                $table->getNameTable() .
                $config['COLUMNS_all']);

        return $this->getField($describe);
    }

    /**
     * get schema auto
     * @param type $table
     * @param array $config
     * @return type
     */
    private function columns_META($table, array $config) {


        $describe = $this->querySchema($config['COLUMNS_META'] .
                $table->getNameTable());


        return $describe;
    }

    /**
     * get schema auto
     * @param type $table
     * @param array $config
     * @return type
     */
    private function columns_master_CHILDREN($table, array $config) {


        $describe = $this->querySimple("SHOW COLUMNS FROM " . $table .
                $config['CHILDREN']['MASTER']);

        return $this->getField($describe);
    }

    /**
     * get schema auto
     * @param type $table
     * @param array $config
     * @return type
     */
    private function columns_default_CHILDREN($table, array $config) {


        $describe = $this->querySimple("SHOW COLUMNS FROM " . $table .
                $config['CHILDREN']['DEFAULT']);

        return $this->getField($describe);
    }

    /**
     * get schema auto
     * @param type $table
     * @param array $config
     * @return type
     */
    private function columns_all_CHILDREN($table, array $config) {

        $describe = $this->querySimple("SHOW COLUMNS FROM " . $table .
                $config['CHILDREN']['ALL']);



        return $this->getField($describe);
    }

    /**
     * get schema auto
     * @param type $table
     * @param array $config
     * @return type
     */
    private function FOREIGN_KEY($table, array $config) {
        if (isset($config['FOREIGN_KEY']) and ! empty($config['FOREIGN_KEY'])) {
            $describe = $this->querySimple("SHOW COLUMNS FROM " .
                    $table->getNameTable() .
                    $config['FOREIGN_KEY']);
        }


        return $this->getField($describe);
    }

    /**
     * get schema auto
     * @param type $table
     * @param array $config
     * @return type
     */
    private function FILES($table, array $config) {
        if (isset($config['FILES']) and ! empty($config['FILES'])) {
            $describe = $this->querySimple("SHOW COLUMNS FROM " .
                    $table->getNameTable() .
                    $config['FILES']);
        }


        return $this->getField($describe);
    }

    /**
     * get schema auto
     * @param type $table
     * @param array $config
     * @return type
     */
    private function STATISTIQUE($table, array $config) {

        $describe = $this->querySimple("SHOW COLUMNS FROM " .
                $table->getNameTable() .
                $config['STATISTIQUE']);



        return $this->getField($describe);
    }

    /**
     * get schema auto
     * @param type $mainTable
     * @param type $config
     * @param type $DB_name
     * @return array
     */
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

    /**
     * get schema auto
     * @param array $describe
     * @return array
     */
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
        $schmaTabls = [];
        foreach (self::$allSchema as $Schema) {
            $schmaTabls[] = Tools::parse_object_TO_array($Schema);
        }
        self::setgenerateCACHE_SELECT($schmaTabls);
    }

    /**
     * nam base donnee
     * @return string
     */
    private static function getNameDataBase(): string {
        return self::getConfigDB(self::dbname);
    }

    /**
     * cache json databas schema database
     * @return bool
     */
    private static function is_set_cache(): bool {
        return self::getConfigDB(self::cache);
    }

    /**
     * SCHEMA SELECT MANUAL mastre default All ...
     * @param type $name
     * @return array
     */
    private static function getSCHEMA_SELECT_MANUAL(): array {
        return self::getFileConfigDB(self::SCHEMA_SELECT_MANUAL);
    }

    /**
     * regle pour select schema auto
     * @return array
     */
    private static function getSCHEMA_SELECT_AUTO(): array {
        return self::getFileConfigDB(self::SCHEMA_SELECT_AUTO);
    }

    /**
     * get cache shema
     * @return array
     */
    private static function getgenerateCACHE_SELECT(): array {
        return self::getFileConfigDB(self::CACHE_SELECT);
    }

    /**
     * set cache schema par table
     * @param type $schmaTabls
     */
    private static function setgenerateCACHE_SELECT($schmaTabls) {
        self::getFileConfigDB()->set($schmaTabls, self::CACHE_SELECT);
    }

    /**
     * remove cache shema
     */
    private static function removeCACHE_SELECT() {
        self::getFileConfigDB()->remove(self::CACHE_SELECT);
    }

    /**
     * set self::$allSchema 
     */
    private function getALLschema_cache() {
        if (empty(self::$allSchema)) {

            if (self::is_set_cache()) {
                $allSchema = [];

                foreach (self::getgenerateCACHE_SELECT() as $table) {
                    $allSchema[] = (new EntitysSchema())->Instance($table);
                }
                self::$allSchema = $allSchema;
            }
        }
    }

    /**
     * set self::$allSchema 
     */
    private function getALLschema_manule() {
        if (empty(self::$allSchema)) {
            $allSchema = [];
            foreach (self::getSCHEMA_SELECT_MANUAL() as $table) {
                $allSchema[] = (new EntitysSchema())->Instance($table);
            }
            self::$allSchema = $allSchema;
        }
    }

    /**
     * set self::$allSchema 
     */
    private function getALLschema_auto() {
        if (empty(self::$allSchema)) {

            $config = self::getSCHEMA_SELECT_AUTO();
            $DB_name = self::getNameDataBase();
            $sql = ' SELECT table_name as NameTable FROM INFORMATION_SCHEMA.PARTITIONS WHERE TABLE_SCHEMA = "' . $DB_name . '" and  table_name not LIKE("r\_%") ';
            $allSchema = $this->querySchema($sql);
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
            self::$allSchema = $allSchema;
        }
    }

}
