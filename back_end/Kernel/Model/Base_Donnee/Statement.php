<?php

namespace Kernel\Model\Base_Donnee;

use Kernel\INTENT\Intent;
use Kernel\Model\Base_Donnee\RUN;
use Kernel\Model\Base_Donnee\Schema;
use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Query\QuerySQL;
use TypeError;

class Statement extends RUN {

    private $shema;

    public function __construct($PathConfigJsone, $table) {

        $this->shema = new Schema($PathConfigJsone);

        parent::__construct($PathConfigJsone, new EntitysDataTable(), $this->shema->getschema($table));
    }

    function getTable() {
        return $this->entitysSchema->getPARENT();
    }

    //////////////////////////////////////////////////////////////:
    public static function entitys_TO_array($object): array {
        if (is_array($object)) {
            return $object;
        }
        $array = [];
        foreach ($object as $key => $value) {
            $array[$key] = $value;
        }
        return $array;
    }

    ////////////////////////////////////////////////////////////////////////////




    public function update($data, $condition) {

        return (new QuerySQL())
                        ->update($this->getTable())
                        ->set($data)
                        ->where($condition);
    }

    public function delete($condition) {



        $delete = (new QuerySQL())
                ->delete($condition)
                ->from($this->getTable());

        $this->exec($delete);
    }

    public function insert(array $dataForm, $mode): Intent {
        if ($mode == Intent::MODE_INSERT) {
            $intent = Intent::parse($dataForm, $this->entitysSchema, $mode);

            $data = ($intent->getEntitysDataTable()[0]); // data send FORM
            unset($data->id);   // remove id
            $name_CHILDRENs = (array_keys($intent->getEntitysSchema()->getCHILDREN())); // name childern array
            $dataCHILDRENs = [];

            foreach ($name_CHILDRENs as $name_CHILDREN) {
                if (isset($data->$name_CHILDREN)) {
                    $dataCHILDRENs[$name_CHILDREN] = $data->$name_CHILDREN; // charge $dataCHILDREN
                    unset($data->$name_CHILDREN); // remove CHILDREN in $data
                }
            }

            $data = self::entitys_TO_array($data);


            $querySQL = (new QuerySQL())->// exec query sql insert to parent table
                    insertInto($intent->getEntitysSchema()->getPARENT())
                    ->value($data);

            $id_parent = $this->exec($querySQL); // return id rowe set data parent table


            /**
             * code insert data to relation table
             */
            if (!empty($dataCHILDRENs)) {
                foreach ($dataCHILDRENs as $name_table_CHILDREN => $id_CHILDRENs) {
                    foreach ($id_CHILDRENs as $id_CHILD) {
                        $querySQL = (new QuerySQL())->
                                insertInto("r_" . $intent->getEntitysSchema()->getPARENT() . "_" . $name_table_CHILDREN)
                                ->value([
                            "id_" . $intent->getEntitysSchema()->getPARENT() => $id_parent,
                            "id_" . $name_table_CHILDREN => $id_CHILD
                        ]);

                        $this->exec($querySQL);
                    }
                }
            }
        } else {
            throw new TypeError(" ERROR mode Intent ==> mode!= MODE_INSERT ");
        }
        return $this->Select(Intent::MODE_SELECT_ALL_ALL, "{$intent->getEntitysSchema()->getPARENT()}.id=$id_parent");
    }

////////////////////////////////////////////////////////////////////////////////
    public function Select(array $mode, $condition): Intent {

        $schema = $this->entitysSchema;

        if (Intent::is_PARENT_MASTER($mode)) {
            $Entitys = $this->query((new QuerySQL())
                            ->select($schema->select_master())
                            ->from($schema->getPARENT())
                            ->join($schema->getFOREIGN_KEY())
                            ->where($condition));
        } elseif (Intent::is_PARENT_ALL($mode)) {
            $Entitys = $this->query((new QuerySQL())
                            ->select($schema->select_all())
                            ->from($schema->getPARENT())
                            ->join($schema->getFOREIGN_KEY())
                            ->where($condition));
        }
        $this->setDataJoins($Entitys, $mode);

        return new Intent($schema, $Entitys, $mode);
    }

    private function setDataJoins(array $Entitys, array $mode) {
        $schema = $this->entitysSchema;

        foreach ($Entitys as $Entity) {
            if (!empty($schema->get_table_CHILDREN())and Intent::is_get_CHILDREN($mode)) {
                foreach ($schema->get_table_CHILDREN() as $tablechild) {
                    $Entity->setDataJOIN($tablechild, $this->query((
                                            new QuerySQL())
                                            ->select($schema->select_CHILDREN($tablechild, $mode[1]))
                                            ->from($schema->getPARENT())
                                            ->join($tablechild, " INNER ", true)
                                            ->where($schema->getPARENT() . ".id = " . $Entity->id)));
                }
            } else {
                $Entity->setDataJOIN("empty", []);
            }
        }
    }

////////////////////////////////////////////////////////////////////////////////
    public function formSelect(array $mode): Intent {

        $schema = $this->entitysSchema;
        // data form
        /// charge select input
        $Entitys_FOREIGNs = $this->datachargeselect();
        $data = [
            "FOREIGN_KEYs" => $Entitys_FOREIGNs, "CHILDRENs" => [],"Default" => [],
        ];
        // schem form
        /// new EntitysSchema pour form select
        $schemaFOREIGN_KEY = new \Kernel\Model\Entitys\EntitysSchema();
        $schemaFOREIGN_KEY->setPARENT($schema->getPARENT());
        $schemaFOREIGN_KEY->setCOLUMNS_META($schema->getCOLUMNS_META(["Key" => "MUL"]));
        $schemaFOREIGN_KEY->setFOREIGN_KEY($schema->getFOREIGN_KEY());


        return new Intent($schemaFOREIGN_KEY, $data, $mode);
    }

    public function form(array $mode, $condition): Intent {

        $schema = $this->entitysSchema;
        $nameTable_FOREIGNs = $schema->getFOREIGN_KEY();
        /// charge select input
        $Entitys_FOREIGNs = [];
        foreach ($nameTable_FOREIGNs as $nameTable_FOREIGN) {
            $schem_Table_FOREIGN = $this->shema->getschema($nameTable_FOREIGN);

            if ($condition == "") {
                $Entitys_FOREIGNs[$nameTable_FOREIGN] = $this->query((new QuerySQL())
                                ->select($schem_Table_FOREIGN->select_all())
                                ->from($schem_Table_FOREIGN->getPARENT())
                                ->join($schem_Table_FOREIGN->getFOREIGN_KEY())
                                ->query()
                );
            } else {
                $Entitys_FOREIGNs[$nameTable_FOREIGN] = $this->query((new QuerySQL())
                                ->select($schem_Table_FOREIGN->select_all())
                                ->from($schem_Table_FOREIGN->getPARENT())
                                ->join($schem_Table_FOREIGN->getFOREIGN_KEY())
                                ->where($schem_Table_FOREIGN->getPARENT() . ".id=" . $condition[$schem_Table_FOREIGN->getPARENT()])->query()
                );
            }
        }



///
        //// charge multi select
        $nameTable_CHILDRENs = $schema->get_table_CHILDREN();
        $Entitys_CHILDRENs = [];

        foreach ($nameTable_CHILDRENs as $table_CHILDREN) {
            $schem_Table_CHILDREN = $this->shema->getschema($table_CHILDREN);

            $Entitys_CHILDRENs[$table_CHILDREN] = $this->query(((new QuerySQL())
                            ->select($schem_Table_CHILDREN->select_master())
                            ->from($schem_Table_CHILDREN->getPARENT())
                            ->join($schem_Table_CHILDREN->getFOREIGN_KEY())
                            ->independent($schema->getPARENT())
                            ->where("raison_sociale" . ".id=" . $condition["raison_sociale"])->query()));
        }


        $data = ["FOREIGN_KEYs" => $Entitys_FOREIGNs,
            "CHILDRENs" => $Entitys_CHILDRENs,
            "Default" => []];


        return new Intent($schema, $data, $mode);
    }

    public function formDefault(array $mode, $condition): Intent {
        $schema = $this->entitysSchema;


        /// charge select input
        $nameTable_FOREIGNs = $schema->getFOREIGN_KEY();
        $Entitys_FOREIGNs = [];
        foreach ($nameTable_FOREIGNs as $nameTable_FOREIGN) {
            $schem_Table_FOREIGN = $this->shema->getschema($nameTable_FOREIGN);


            $Entitys_FOREIGNs[$nameTable_FOREIGN] = $this->query((new QuerySQL())
                            ->select($schem_Table_FOREIGN->select_master())
                            ->from($schem_Table_FOREIGN->getPARENT())
                            ->join($schem_Table_FOREIGN->getFOREIGN_KEY())
                            ->query()
            );
        }

        if ($Entitys_FOREIGNs == []) {
            /// data Default
            $Entitys = $this->query((new QuerySQL())
                            ->select($schema->select_all())
                            ->from($schema->getPARENT())
                            ->join($schema->getFOREIGN_KEY())
                            ->where($condition));
            $Entity = $Entitys[0];


            $data = ["FOREIGN_KEYs" => $Entitys_FOREIGNs,
                "CHILDRENs" => [],
                "Default" => [$Entity]];
        } else {
            /// data Default
            $Entitys = $this->query((new QuerySQL())
                            ->select($schema->select_all())
                            ->column("raison_sociale.id as raison_sociale_id")
                            ->from($schema->getPARENT())
                            ->join($schema->getFOREIGN_KEY())
                            ->where($condition));
            $Entity = $Entitys[0];






            // data join (children enfant drari lbrahch ....)
            $nameTable_CHILDRENs = $schema->get_table_CHILDREN();


            if (!empty($nameTable_CHILDRENs)) {
                $Entitys_CHILDRENs = [];

                /// charge enfant independent
                foreach ($nameTable_CHILDRENs as $table_CHILDREN) {
                    $schem_Table_CHILDREN = $this->shema->getschema($table_CHILDREN);

                    $Entitys_CHILDRENs[$table_CHILDREN] = $this->query(((new QuerySQL())
                                    ->select($schem_Table_CHILDREN->select_master())
                                    ->from($schem_Table_CHILDREN->getPARENT())
                                    ->join($schem_Table_CHILDREN->getFOREIGN_KEY())
                                    ->independent($schema->getPARENT())
                                    ->where("raison_sociale.id=" . $Entity->raison_sociale_id)->query()
                            )
                    );
                }
/// charge enfant data lien
                foreach ($nameTable_CHILDRENs as $tablechild) {
                    $schem_Table_CHILDREN = $this->shema->getschema($tablechild);
                    $Entity->setDataJOIN($tablechild, $this->query((
                                            new QuerySQL())
                                            ->select($schem_Table_CHILDREN->select_master())
                                            ->from($schema->getPARENT())
                                            ->join($tablechild, " INNER ", true)
                                            ->where($schema->getPARENT() . ".id = " . $Entity->id)));
                }
            } else {
                $Entitys_CHILDRENs = [];
                $Entity->setDataJOIN("empty", []);
            }


            $data = ["FOREIGN_KEYs" => $Entitys_FOREIGNs,
                "CHILDRENs" => $Entitys_CHILDRENs,
                "Default" => [$Entity]];
        }




        return new Intent($schema, $data, $mode);
    }

    ///////////////////////////////////////////////////////////////////
    private function datachargeselect() {
        $schema = $this->entitysSchema;

        $nameTable_FOREIGNs = $schema->getFOREIGN_KEY();
        /// charge select input
        $Entitys_FOREIGNs = [];
        foreach ($nameTable_FOREIGNs as $nameTable_FOREIGN) {
            $schem_Table_FOREIGN = $this->shema->getschema($nameTable_FOREIGN);

            $Entitys_FOREIGNs[$nameTable_FOREIGN] = $this->query((new QuerySQL())
                            ->select($schem_Table_FOREIGN->select_all())
                            ->from($schem_Table_FOREIGN->getPARENT())
                            ->join($schem_Table_FOREIGN->getFOREIGN_KEY()));
        }
        return $Entitys_FOREIGNs;
    }

}
