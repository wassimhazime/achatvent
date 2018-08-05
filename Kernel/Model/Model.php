<?php

namespace Kernel\Model;

use Kernel\AWA_Interface\ModelInterface;
use Kernel\INTENT\Intent;
use Kernel\INTENT\Intent_Form;
use Kernel\Model\Base_Donnee\MetaDatabase;
use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Entitys\EntitysSchema;
use Kernel\Model\Query\QuerySQL;
use Kernel\Tools\Tools;
use TypeError;
use function array_keys;
use function date;
use function implode;
use function var_dump;

class Model extends MetaDatabase implements ModelInterface {

    protected $is_null = true;
    protected $table;
    protected $schema;

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

    public function getAllTables(): array {
        $names_Tables = [];
        $Schemas = $this->getALLschema();
        foreach ($Schemas as $schema) {
            $names_Tables[] = $schema->getNameTable();
        }
        return $names_Tables;
    }

    public function getTable(): string {

        if ($this->is_null()) {

            throw new \TypeError(" set table ==> call function setTable()");
        }
        return $this->table;
    }

    function setTable(string $table): bool {
        if ($this->is_Table($table)) {
            $this->is_null = false;
            $this->table = $table;
            $this->schema = $this->getschema($table);
        } else {
            $this->is_null = false;
        }
        return !$this->is_null;
    }

    function _getSchema(): EntitysSchema {
        return $this->schema;
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

    public function formSelect(): Intent_Form {
        $schema = $this->schema;
        $schemaFOREIGN_KEY = new EntitysSchema();
        $schemaFOREIGN_KEY->setNameTable($schema->getNameTable());
        $schemaFOREIGN_KEY->setCOLUMNS_META($schema->getCOLUMNS_META(["Key" => "MUL"]));
        $schemaFOREIGN_KEY->setFOREIGN_KEY($schema->getFOREIGN_KEY());
        $META_data = $schemaFOREIGN_KEY->getCOLUMNS_META();
        $Charge_data = [];
        $Charge_data ["select"] = $this->datachargeselect();
        $Charge_data["multiselect"] = [];
        $Charge_data["PARENT"] = [];
        $Default_Data = [];
        return new Intent_Form($META_data, $Charge_data, $Default_Data);
    }

    public function form($condition): Intent_Form {

        $META_data = $this->schema->getCOLUMNS_META();

        $Charge_data = [];
        $Charge_data ["select"] = $this->datachargeselect($condition);
        $Charge_data["multiselect"] = $this->dataChargeMultiSelectIndependent($condition);
        $Charge_data["PARENT"] = [];
        $Default_Data = [];
        return new Intent_Form($META_data, $Charge_data, $Default_Data);
    }

    public function formDefault(array $conditionDefault): Intent_Form {
        $schema = $this->schema;

        // data Default
        $Entitys = $this->prepareQuery((new QuerySQL())
                        ->select($schema->select_all())
                        ->from($schema->getNameTable())
                        ->join($schema->getFOREIGN_KEY())
                        ->where($conditionDefault)
                        ->prepareQuery());


        if (!isset($Entitys[0])) {
            die("<h1>je ne peux pas insérer données  doublons ou vide </h1> ");
        }

        $Entity = $Entitys[0];

        $conditionformSelect = $this->condition_formSelect_par_condition_Default($conditionDefault);
        // data join (children enfant drari lbrahch ....)
        $nameTable_CHILDRENs = $schema->get_table_CHILDREN();
        $Entitys_CHILDRENs = [];
        if (!empty($nameTable_CHILDRENs)) {
            /// charge enfant data no lier lien
            $Entitys_CHILDRENs = $this->dataChargeMultiSelectIndependent($conditionformSelect);
            /// charge enfant data lien
            foreach ($nameTable_CHILDRENs as $tablechild) {
                $datacharg = $this->dataChargeMultiSelectDependent($tablechild, $conditionDefault);
                $Entity->setDataJOIN($tablechild, $datacharg);
            }
        }
        $Charge_data = [];
        $Charge_data ["select"] = $this->datachargeselect($conditionformSelect);
        $Charge_data["multiselect"] = $Entitys_CHILDRENs;
        $Charge_data["PARENT"] = [];
        $Default_Data = $Entity;
        return new Intent_Form($schema->getCOLUMNS_META(), $Charge_data, $Default_Data);
    }

    private function datachargeselect(array $condition = []) {
        $schema = $this->schema;
        $nameTable_FOREIGNs = $schema->getFOREIGN_KEY();
        /// charge select input
        $Entitys_FOREIGNs = [];
        foreach ($nameTable_FOREIGNs as $nameTable_FOREIGN) {
            $schem_Table_FOREIGN = $this->getschema($nameTable_FOREIGN);

            $querydataCharge = ( new QuerySQL())
                    ->select($schem_Table_FOREIGN->select_master())
                    ->from($schem_Table_FOREIGN->getNameTable())
                    ->join($schem_Table_FOREIGN->getFOREIGN_KEY());

            if (!empty($condition) && isset($condition[$nameTable_FOREIGN])) {
                $con = [$nameTable_FOREIGN . ".id" => $condition[$nameTable_FOREIGN]];

                $querydataCharge->where($con);
            }
            $Entitys_FOREIGNs[$nameTable_FOREIGN] = $this->prepareQuery($querydataCharge->prepareQuery());
        }
        return $Entitys_FOREIGNs;
    }

    private function dataChargeMultiSelectIndependent(array $condition = []) {
        $schema = $this->schema;
        $nameTable_CHILDRENs = $schema->get_table_CHILDREN();
        $Entitys_CHILDRENs = [];
        foreach ($nameTable_CHILDRENs as $table_CHILDREN) {
            $schem_Table_CHILDREN = $this->getschema($table_CHILDREN);
            $FOREIGN_KEY_CHILDRENs = $schem_Table_CHILDREN->getFOREIGN_KEY();

            $querydataCharge = (new QuerySQL())->select($schem_Table_CHILDREN->select_NameTable())
                    ->from($schem_Table_CHILDREN->getNameTable())
                    ->join($FOREIGN_KEY_CHILDRENs)
                    ->independent($schema->getNameTable());
            $query = $this->query_enfant_lier_formSelect($querydataCharge, $condition, $FOREIGN_KEY_CHILDRENs);
            $Entitys_CHILDRENs[$table_CHILDREN] = $this->prepareQuery($query->prepareQuery());
        }
        return $Entitys_CHILDRENs;
    }

    private function dataChargeMultiSelectDependent($tablechild, array $condition) {
        $schema = $this->schema;
        $schem_Table_CHILDREN = $this->getschema($tablechild);
        return $this->prepareQuery((
                                new QuerySQL())
                                ->select($schem_Table_CHILDREN->select_NameTable())
                                ->from($schema->getNameTable())
                                ->join($tablechild, " INNER ", true)
                                ->where($condition)
                                ->prepareQuery());
    }

    private function query_enfant_lier_formSelect($query, array $condition, array $FOREIGN_KEY_CHILDRENs) {
        if (!empty($condition) and ! empty($FOREIGN_KEY_CHILDRENs)) {
            foreach ($FOREIGN_KEY_CHILDRENs as $FOREIGN_KEY) {
                if (isset($condition[$FOREIGN_KEY])) {
                    $query->where($FOREIGN_KEY . ".id=" . $condition[$FOREIGN_KEY]);
                }
            }
        }
        return $query;
    }

    private function condition_formSelect_par_condition_Default($condition): array {
        $schema = $this->schema;
        $FOREIGN_KEYs = $schema->getFOREIGN_KEY();
        if (empty($FOREIGN_KEYs)) {
            return [];
        }
        $columnFOREIGN_KEY = [];
        foreach ($FOREIGN_KEYs as $FOREIGN_KEY) {
            $columnFOREIGN_KEY[] = "$FOREIGN_KEY.id as $FOREIGN_KEY" . "_id";
        }
        $Entitys = $this->prepareQuery((new QuerySQL())
                        ->select($columnFOREIGN_KEY)
                        ->from($schema->getNameTable())
                        ->join($schema->getFOREIGN_KEY())
                        ->where($condition)
                        ->prepareQuery());
        $Entity = $Entitys[0];

        /// si voir-table-68765868769698 => row note exist
        ///   if(empty(Tools::entitys_TO_array($Entity))){ return [];}

        $cond = [];
        foreach ($FOREIGN_KEYs as $FOREIGN_KEY) {
            $id = $FOREIGN_KEY . "_id";
            $cond[$FOREIGN_KEY] = $Entity->$id;
        }
        return $cond;
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

    public function select_in(array $mode, $id, $condition): Intent {
        $schema = $this->_getSchema();
        if (Intent::is_show_MASTER($mode)) {
            $champs = $schema->select_master();
        } elseif (Intent::is_show_ALL($mode)) {
            $champs = $schema->select_all();
        } elseif (Intent::is_show_DEFAULT($mode)) {
            $champs = $schema->select_default();
        }
        $sql = (new QuerySQL())
                ->select($champs)
                ->from($schema->getNameTable())
                ->join($schema->getFOREIGN_KEY())
                ->whereIn($id, $condition)
                ->prepareQuery();
        $Entitys = $this->prepareQuery($sql);
        $this->setDataJoins($Entitys, $mode);
        return new Intent($schema, $Entitys, $mode);
    }

    public function select(array $mode, $condition): Intent {
        $schema = $this->_getSchema();
        if (Intent::is_show_MASTER($mode)) {
            $champs = $schema->select_master();
        } elseif (Intent::is_show_ALL($mode)) {
            $champs = $schema->select_all();
        } elseif (Intent::is_show_DEFAULT($mode)) {
            $champs = $schema->select_default();
        }
        $sql = (new QuerySQL())
                ->select($champs)
                ->from($schema->getNameTable())
                ->join($schema->getFOREIGN_KEY())
                ->where($condition)
                ->prepareQuery();
        $Entitys = $this->prepareQuery($sql);
        $this->setDataJoins($Entitys, $mode);
        return new Intent($schema, $Entitys, $mode);
    }

    public function is_id($id): bool {
        $schema = $this->_getSchema();
        $condition = ["{$schema->getNameTable()}.id" => $id];
        $Entitys = $this->prepareQuery((new QuerySQL())
                        ->select()
                        ->from($schema->getNameTable())
                        ->where($condition)
                        ->prepareQuery());
        return (!empty($Entitys));
    }

    public function find_by_id($id): array {
        $schema = $this->_getSchema();
        $condition = ["{$schema->getNameTable()}.id" => $id];
        $Entitys = $this->prepareQuery((new QuerySQL())
                        ->select($schema->getCOLUMNS_master())
                        ->column($schema->getFOREIGN_KEY())
                        ->from($schema->getNameTable())
                        ->where($condition)->prepareQuery());
        return Tools::entitys_TO_array($Entitys[0]);
    }

    private function setDataJoins(array $Entitys, array $mode) {
        $schema = $this->_getSchema();
        foreach ($Entitys as $Entity) {
            if (!empty($schema->get_table_CHILDREN())and Intent::is_get_CHILDREN($mode)) {
                foreach ($schema->get_table_CHILDREN() as $tablechild) {
                    $sql = (new QuerySQL())
                            ->select($schema->select_CHILDREN($tablechild, $mode[1]))
                            ->from($schema->getNameTable())
                            ->join($tablechild, " INNER ", true)
                            ->where($schema->getNameTable() . ".id = " . $Entity->id)
                            ->prepareQuery();
                    $Entity->setDataJOIN($tablechild, $this->prepareQuery($sql));
                }
            } else {
                $Entity->setDataJOIN("empty", []);
            }
        }
    }

    public function get_idfile($condition): string {
        $schema = $this->_getSchema();
        if (empty($schema->getFILES())) {
            return "";
        }
        $Entitys = $this->prepareQuery((new QuerySQL())
                        ->select($schema->getFILES())
                        ->from($schema->getNameTable())
                        ->where($condition)->prepareQuery());
        $datafile = Tools::entitys_TO_array($Entitys[0]);
        return implode($datafile);
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

    public function update(array $dataForm, $mode): int {
        if ($mode != Intent::MODE_UPDATE) {
            throw new TypeError(" ERROR mode Intent ==> mode!= MODE_UPDATE ");
        }
        $intent = $this->parse($dataForm, $this->schema, $mode);
        $dataCHILDRENs = $this->charge_data_childe($intent);
        $data_NameTable = $this->remove_childe_in_data($intent);
        $id_NameTable = $data_NameTable["id"];
        unset($data_NameTable["id"]);   // remove id
        // exec query sql insert to NameTable table
        $datenow = date("Y-m-d-H-i-s");
        $data_NameTable["date_modifier"] = $datenow;
        $querySQL = (new QuerySQL())->
                update($this->getTable())
                ->set($data_NameTable)
                ->where(["id" => $id_NameTable])
                ->prepareQuery();
        $this->prepareQueryEXEC($querySQL);
        /**
         * code delete insert  data to relation table
         */
        //delete
        $this->delete_data_childe($intent, $id_NameTable);
        //insert
        $this->insert_data_childe($intent, $id_NameTable, $dataCHILDRENs);
        return $id_NameTable;
    }

    public function delete(array $condition): int {
        // one  item

        $delete = (new QuerySQL())
                ->delete($this->getTable())
                ->where($condition)
                ->prepareQuery();
        return $this->prepareQueryEXEC($delete);
    }

    public function insert(array $dataForm, $mode): int {
        if ($mode != Intent::MODE_INSERT) {
            throw new TypeError(" ERROR mode Intent ==> mode!= MODE_INSERT ");
        }
        $intent = $this->parse($dataForm, $this->schema, $mode);
        $dataCHILDRENs = $this->charge_data_childe($intent);

        $data_NameTable = $this->remove_childe_in_data($intent);
        unset($data_NameTable["id"]);   // remove id
        // exec query sql insert to NameTable table
        $datenow = date('Y-m-d H:i:s');
        $data_NameTable["date_ajoute"] = $datenow;
        $data_NameTable["date_modifier"] = $datenow;

        $querySQL = (new QuerySQL())
                ->insertInto($this->getTable())
                ->value($data_NameTable)
                ->prepareQuery();
        // return id rowe set data NameTable table

        $id_NameTable = $this->prepareQueryEXEC($querySQL);
        /**
         * code insert data to relation table
         */
        $this->insert_data_childe($intent, $id_NameTable, $dataCHILDRENs);
        return $id_NameTable;
    }

    public function insert_inverse(array $dataForms, $id_parent, $mode): int {


        if ($mode != Intent::MODE_INSERT) {
            throw new TypeError(" ERROR mode Intent ==> mode!= MODE_INSERT ");
        }
        $id_cheldrns = [];
        foreach ($dataForms as $dataForm) {
            $intent = $this->parse($dataForm, $this->schema, $mode);
            $dataCHILDRENs = $this->charge_data_childe($intent);
            $data_NameTable = $this->remove_childe_in_data($intent);
            unset($data_NameTable["id"]);   // remove id
            // exec query sql insert to NameTable table
            $datenow = date("Y-m-d-H-i-s");
            $data_NameTable["date_ajoute"] = $datenow;
            $data_NameTable["date_modifier"] = $datenow;
            $querySQL = (new QuerySQL())
                            ->insertInto($this->getTable())
                            ->value($data_NameTable)->query();
            // return id rowe set data NameTable table
            $id_cheldrns[] = $this->exec($querySQL);
        }
        var_dump($id_cheldrns, $id_parent);

        foreach ($id_cheldrns as $id_cheld) {
            $querySQL = (new QuerySQL())->
                            insertInto("r_achats_achat")
                            ->value([
                                "id_achats" => $id_parent,
                                "id_achat" => $id_cheld
                            ])->query();
            $this->exec($querySQL);
        }
        /**
         * code insert data to relation table
         */
        //  $this->insert_data_childe($intent, $id_NameTable, $dataCHILDRENs);
        return 0;
    }

////////////////////////////////////////////////////////////////////////////////
    /**
     *
      charge data variables
     */
    private function charge_data_childe($intent) {
        $data = ($intent->getEntitysDataTable()[0]);
        $name_CHILDRENs = (array_keys($intent->getEntitysSchema()->getCHILDREN())); // name childern array
        $dataCHILDRENs = [];
        foreach ($name_CHILDRENs as $name_CHILDREN) {
            if (isset($data->$name_CHILDREN)) {
                $dataCHILDRENs[$name_CHILDREN] = $data->$name_CHILDREN; // charge $dataCHILDREN
            }
        }

        return $dataCHILDRENs;
    }

    private function remove_childe_in_data($intent) {
        $data = ($intent->getEntitysDataTable()[0]);
        $name_CHILDRENs = (array_keys($intent->getEntitysSchema()->getCHILDREN())); // name childern array
        foreach ($name_CHILDRENs as $name_CHILDREN) {
            if (isset($data->$name_CHILDREN)) {
                unset($data->$name_CHILDREN); // remove CHILDREN in $data
            }
        }
        return Tools::entitys_TO_array($data);
    }

    ////////////////////////////////////////////////////////////////////////////
    /**
     *
      exec SQL des tables relations
     */
    private function insert_data_childe($intent, $id_NameTable, $dataCHILDRENs) {
        foreach ($dataCHILDRENs as $name_table_CHILDREN => $id_CHILDRENs) {
            foreach ($id_CHILDRENs as $id_CHILD) {
                $querySQL = (new QuerySQL())->
                                insertInto("r_" . $intent->getEntitysSchema()->getNameTable() . "_" . $name_table_CHILDREN)
                                ->value([
                                    "id_" . $intent->getEntitysSchema()->getNameTable() => $id_NameTable,
                                    "id_" . $name_table_CHILDREN => $id_CHILD
                                ])->prepareQuery();
                $this->prepareQueryEXEC($querySQL);
            }
        }
    }

    private function delete_data_childe($intent, $id_NameTable) {
        $name_CHILDRENs = (array_keys($intent->getEntitysSchema()->getCHILDREN())); // name childern array
        foreach ($name_CHILDRENs as $name_table_CHILDREN) {
            $sqlquery = (new QuerySQL())
                    ->delete("r_" . $intent->getEntitysSchema()->getNameTable() . "_" . $name_table_CHILDREN)
                    ->where(["id_" . $intent->getEntitysSchema()->getNameTable() => $id_NameTable])
                    ->prepareQuery();
            $this->prepareQueryEXEC($sqlquery);
        }
    }

    /////////////////////////////
    /// insert update
    private function parse(array $data, EntitysSchema $schema, array $mode): Intent {
        if (Tools::isAssoc($data) and isset($data)) {
            return (new Intent($schema, ((new EntitysDataTable())->set($data)), $mode));
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

    private $schema_statistique = [];

    ////////////////////////////////////////////////////////////////////////////////



    public function chargeDataSelect() {
        $sh = $this->getSchemaStatistique("sum", " ");
        $dataselect = [];
        foreach ($sh as $key => $value) {
            $dataselect[] = $key;
        }
        return $dataselect;
    }

    public function statistique_global() {
        $sh = $this->getALLschema();
        foreach ($sh as $value) {
            $st = ($value->select_statistique_SUM());
            if (!empty($st["select"])) {
                $this->schema_statistique[$st["table"]] = ["champ" => $st["select"],
                    "par" => $st["FOREIGN_KEY"]];
            }
        }
        foreach ($this->schema_statistique as $table => $st) {
            $champ = $st["champ"];
            echo "<h1> $table </h1>";
            $sql = ((new QuerySQL())
                            ->select($champ)
                            ->from($table)
                            ->where("YEAR(`date`)=2018")
                    );
            $entity = $this->query($sql);
            var_dump(Tools::entitys_TO_array($entity)[0]);
        }
    }

    public function statistique_pour(array $query) {
        $startdate = $query["startinputDate"];
        $findate = $query["fininputDate"];
        $tables = $query["Rapports"];
        $json = [];
        foreach ($tables as $table) {
            $json[] = $this->statistique_par($table, $startdate, $findate);
        }
        return Tools::json($json);
    }

    public function statistique_par($table, $startdate, $findat) {
        $schema_statistiqueMIN = $this->getSchemaStatistique("sum", "", $table);
        foreach ($schema_statistiqueMIN as $table => $st) {
            $champ = $st["filds"];
            $par = $st["GroupBy"];
            $st = [];
            foreach ($par as $by) {
                $sql = ((new QuerySQL())
                                ->select($champ)
                                //  ->column("$by.$by")
                                ->from($table)
                                ->whereBETWEEN("date", Tools::date_FR_to_EN($startdate), Tools::date_FR_to_EN($findat))
                        );
                $st = $this->querySimple($sql . " GROUP BY $by ");
                // echo (Tools::json($entity));
                //return $sql . " GROUP BY $by ";
            }
            //  var_dump (($st));
            return Tools::json($st);
        }
    }

    public function total($table, $champ, $alias, $date) {
        $sh = $this->getALLschema();
        foreach ($sh as $value) {
            $st = ($value->select_statistique_SUM());
            if (!empty($st["select"])) {
                $this->schema_statistique[$st["table"]] = ["champ" => $st["select"],
                    "par" => $st["FOREIGN_KEY"]];
            }
        }
        var_dump($this->schema_statistique);
        $sql = "SELECT  SUM($champ) as $alias FROM $table WHERE YEAR(`date`)=$date ";
        $entity = $this->query($sql);
        return Tools::entitys_TO_array($entity);
    }

    public function totalpar($table, $champ, $alias, $date, $by) {
        $sql = "SELECT $by, SUM($champ) as $alias FROM $table WHERE YEAR(`date`)=$date "
                . " GROUP BY $by ";
        $entity = $this->query($sql);
        return Tools::entitys_TO_array($entity);
    }

  



 

}
