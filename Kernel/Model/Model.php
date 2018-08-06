<?php

namespace Kernel\Model;

use Kernel\AWA_Interface\ModelInterface;
use Kernel\INTENT\Intent_Set;
use Kernel\Model\Base_Donnee\MetaDatabase;
use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Query\QuerySQL;
use Kernel\Tools\Tools;
use TypeError;
use function array_keys;
use function date;
use function explode;
use function implode;
use function is_string;
use function var_dump;

class Model extends MetaDatabase implements ModelInterface {
    /*
     * ***************************************************************
     *  |form 
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |

     */ ///****************************************************************////

    /**
     * pour form select or select input
     * @param array $condition
     * @return array
     * 
     */
    protected function get_Data_FOREIGN_KEY(array $condition = []): array {
        $schema = $this->getschema();
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

    /**
     * pour form select or select input
     * @return array
     */
    protected function get_Meta_FOREIGN_KEY(): array {
        $schema = $this->getschema();
        return $schema->getCOLUMNS_META(["Key" => "MUL"]);
    }

    /**
     * 
     * @param array $condition
     * @return type
     */
    protected function dataChargeMultiSelectIndependent(array $condition = []) {
        $schema = $this->getschema();
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

    /**
     * 
     * @param type $tablechild
     * @param array $condition
     * @return type
     */
    protected function dataChargeMultiSelectDependent($tablechild, array $condition) {
        $schema = $this->getschema();
        $schem_Table_CHILDREN = $this->getschema($tablechild);
        return $this->prepareQuery((
                                new QuerySQL())
                                ->select($schem_Table_CHILDREN->select_NameTable())
                                ->from($schema->getNameTable())
                                ->join($tablechild, " INNER ", true)
                                ->where($condition)
                                ->prepareQuery());
    }

    /**
     * 
     * @param type $query
     * @param array $condition
     * @param array $FOREIGN_KEY_CHILDRENs
     * @return type
     */
    protected function query_enfant_lier_formSelect($query, array $condition, array $FOREIGN_KEY_CHILDRENs) {
        if (!empty($condition) and ! empty($FOREIGN_KEY_CHILDRENs)) {
            foreach ($FOREIGN_KEY_CHILDRENs as $FOREIGN_KEY) {
                if (isset($condition[$FOREIGN_KEY])) {
                    $query->where($FOREIGN_KEY . ".id=" . $condition[$FOREIGN_KEY]);
                }
            }
        }
        return $query;
    }

    /**
     * 
     * @param type $condition
     * @return array
     */
    protected function condition_formSelect_par_condition_Default($condition): array {
        $schema = $this->getschema();
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
     *  |show
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |

     */ ///****************************************************************////

    /**
     * pour show or show_in parse mode get les champs|| fildes
     * @param array $mode
     * @return array
     * @throws TypeError
     */
    protected function get_fields(array $mode): array {
        // mode
        $schema = $this->getSchema();
        if ($mode[0] == "MASTER") {
            $fields = $schema->select_master();
        } elseif ($mode[0] == "ALL") {
            $fields = $schema->select_all();
        } elseif ($mode[0] == "DEFAULT") {
            $fields = $schema->select_default();
        } else {
            throw new \TypeError(" Error mode intent");
        }

        return $fields;
    }

    /**
     * pour message and show data table html / json
     * @param array $Entitys
     * @param string $mode
     * @return array EntitysDataTable
     */
    protected function get_Data_CHILDREN(array $Entitys, string $mode): array {
        $schema = $this->getSchema();
        foreach ($Entitys as $Entity) {
            if (!empty($schema->get_table_CHILDREN()) && $mode != "EMPTY") {
                foreach ($schema->get_table_CHILDREN() as $tablechild) {
                    $sql = (new QuerySQL())
                            ->select($schema->select_CHILDREN($tablechild, $mode))
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
        return $Entitys;
    }

    /**
     * pour select data to table
     * @param array $mode
     * @param type $id
     * @return array EntitysDataTable
     */
    public function select(array $mode, $id = true): array {
        if ($id !== true) {
            $id = ["{$this->getTable()}.id" => $id];
        }

        $schema = $this->getSchema();
        $fields = $this->get_fields($mode);

        $sql = (new QuerySQL())
                ->select($fields)
                ->from($schema->getNameTable())
                ->join($schema->getFOREIGN_KEY())
                ->where($id)
                ->prepareQuery();
        $Entitys = $this->prepareQuery($sql);
        return $this->get_Data_CHILDREN($Entitys, $mode[1]);
    }

    /**
     * pour sele data in range 
     * @param array $mode
     * @param string|array $rangeID
     * @return array EntitysDataTable
     */
    public function select_in(array $mode, $rangeID): array {
        $schema = $this->getSchema();
        $fields = $this->get_fields($mode);
        //range
        if (is_string($rangeID)) {
            $rangeID = explode(",", $rangeID);
        }
        $sql = (new QuerySQL())
                ->select($fields)
                ->from($schema->getNameTable())
                ->join($schema->getFOREIGN_KEY())
                ->whereIn("{$this->getTable()}.id", $rangeID)
                ->prepareQuery();
        $Entitys = $this->prepareQuery($sql);

        return $this->get_Data_CHILDREN($Entitys, $mode[1]);
    }

    /**
     * select data BETWEEN 2 value in id
     * @param array $mode
     * @param int $valeur1
     * @param int $valeur2
     * @return array EntitysDataTable
     */
    public function select_BETWEEN(array $mode, int $valeur1, int $valeur2): array {
        $schema = $this->getSchema();
        $fields = $this->get_fields($mode);

        $sql = (new QuerySQL())
                ->select($fields)
                ->from($schema->getNameTable())
                ->join($schema->getFOREIGN_KEY())
                ->whereBETWEEN("{$this->getTable()}.id", $valeur1, $valeur2)
                ->prepareQuery();
        $Entitys = $this->prepareQuery($sql);

        return $this->get_Data_CHILDREN($Entitys, $mode[1]);
    }

    /*
     * ***************************************************************
     *  |set data
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |

     */ ///****************************************************************////
    ///////////////////////////////////////////////////////////
    /**
     * delete one item get id delete
     * @param array $condition
     * @return int
     */

    public function delete(array $condition): int {
        // one  item

        $delete = (new QuerySQL())
                ->delete($this->getTable())
                ->where($condition)
                ->prepareQuery();
        return $this->prepareEXEC($delete);
    }

    /**
     * lier table par childe
     *  exec SQL des tables relations
     * @param string $id_Table
     * @param array $Data_CHILDREN_id
     */
    protected function insert_data_childe(string $id_Table, array $Data_CHILDREN_id, string $table = "") {
        if ($table == "") {
            $table = $this->getTable();
        }


        foreach ($Data_CHILDREN_id as $name_table_CHILDREN => $id_CHILDRENs) {
            foreach ($id_CHILDRENs as $id_CHILD) {
                $querySQL = (new QuerySQL())->
                                insertInto("r_" . $table . "_" . $name_table_CHILDREN)
                                ->value([
                                    "id_" . $table => $id_Table,
                                    "id_" . $name_table_CHILDREN => $id_CHILD
                                ])->prepareQuery();
                $this->prepareEXEC($querySQL);
            }
        }
    }

    /**
     * supprimer lieson de table par childe
     *  exec SQL des tables relations
     * @param string $id_Table
     */
    protected function delete_data_childe(string $id_Table) {
        $name_CHILDRENs = (array_keys($this->getschema()->getCHILDREN())); // name childern array

        foreach ($name_CHILDRENs as $name_table_CHILDREN) {
            $sqlquery = (new QuerySQL())
                    ->delete("r_" . $this->getTable() . "_" . $name_table_CHILDREN)
                    ->where(["id_" . $this->getTable() => $id_Table])
                    ->prepareQuery();
            $this->prepareEXEC($sqlquery);
        }
    }

    /////////////////////////////
    /**
     * crier Intent_Set par data set par form
     * @param array $data
     * @return Intent_Set
     * @throws TypeError
     */
    protected function parse(array $data): Intent_Set {
        $schema = $this->getschema();
        if (Tools::isAssoc($data) and isset($data)) {
            return (new Intent_Set($schema, ((new EntitysDataTable())->set($data))));
        } else {
            throw new TypeError("erreur data set is empty or not arrayAssoc ");
        }
    }

    /**
     * 
     * @param array $dataForm
     * @return int
     */
    public function update(array $dataForm): int {
        $intent_set = $this->parse($dataForm);
        $Data_CHILDREN_id = $intent_set->get_Data_CHILDREN_id();
        $data_table = $intent_set->get_Data_Table();

        $id_Table = $data_table["id"];
        unset($data_table["id"]);   // remove id
        // exec query sql insert to NameTable table
        $datenow = date("Y-m-d-H-i-s");
        $data_table["date_modifier"] = $datenow;
        $querySQL = (new QuerySQL())->
                update($this->getTable())
                ->set($data_table)
                ->where(["id" => $id_Table])
                ->prepareQuery();
        $this->prepareEXEC($querySQL);
        /**
         * code delete insert  data to relation table
         */
        //delete childe
        $this->delete_data_childe($id_Table);
        //insert
        $this->insert_data_childe($id_Table, $Data_CHILDREN_id);
        return $id_Table;
    }

    /**
     * 
     * @param array $dataForm
     * @return int
     */
    public function insert(array $dataForm): int {


        $intent_set = $this->parse($dataForm);
        $Data_CHILDREN_id = $intent_set->get_Data_CHILDREN_id();
        $data_table = $intent_set->get_Data_Table();


        unset($data_table["id"]);   // remove id
        // exec query sql insert to NameTable table
        $datenow = date('Y-m-d H:i:s');
        $data_table["date_ajoute"] = $datenow;
        $data_table["date_modifier"] = $datenow;

        $querySQL = (new QuerySQL())
                ->insertInto($this->getTable())
                ->value($data_table)
                ->prepareQuery();
        // return id rowe set data NameTable table

        $id_Table = $this->prepareEXEC($querySQL);
        /**
         * code insert data to relation table
         */
        $this->insert_data_childe($id_Table, $Data_CHILDREN_id);
        return $id_Table;
    }

    /**
     * insert data inverse set data childe et set relation
     * @param array $dataForms
     * @param int $id_table_parent
     * @param string $table_parent
     * @return int
     */
    public function insert_inverse(array $dataForms, int $id_table_parent, string $table_parent = ""): int {
        $id_cheldrns = [];
        $table = $this->getTable();
        if ($table_parent == "") {
            $table_parent = $this->getTable() . "s";
        }
        /**
         * insert data table child
         */
        foreach ($dataForms as $dataForm) {
            $id_cheldrns[] = $this->insert($dataForm);
        }
        /**
         * code insert data to relation table
         */
        $this->insert_data_childe($id_table_parent, [$table => $id_cheldrns], $table_parent);


        return $id_table_parent;
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

    /*
     * ***************************************************************
     *  |tools
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |
     *  |

     */ ///****************************************************************////

    /**
     * 
     * @param string $id
     * @return bool
     */
    public function is_id(string $id): bool {
        $Entitys = $this->find_by_id($id);
        return (!empty($Entitys));
    }

    /**
     * 
     * @param type $id
     * @return array
     */
    public function find_by_id($id): array {
        $schema = $this->getSchema();
        $condition = ["{$schema->getNameTable()}.id" => $id];
        $Entitys = $this->prepareQuery((new QuerySQL())
                        ->select($schema->getCOLUMNS_master())
                        ->column($schema->getFOREIGN_KEY())
                        ->from($schema->getNameTable())
                        ->where($condition)->prepareQuery());
        return Tools::entitys_TO_array($Entitys[0]);
    }

    /**
     * get id (exmple:<a class="btn "  role="button" href="/CRM/files/clients_2018-08-01-16-32-12"  data-regex="/clients_2018-08-01-16-32-12/" > <spam class="glyphicon glyphicon-download-alt"></spam> 6</a>)
     * set to table de file upload
     * 
     * @param string $id
     * @return string
     */
    public function get_idfile(string $id): string {
        $schema = $this->getSchema();
        if (empty($schema->getFILES())) {
            return "";
        }
        $Entitys = $this->prepareQuery((new QuerySQL())
                        ->select($schema->getFILES())
                        ->from($schema->getNameTable())
                        ->where(["{$this->getTable()}.id" => $id])
                        ->prepareQuery());
        $datafile = Tools::entitys_TO_array($Entitys[0]);

        return implode($datafile);
    }

}
