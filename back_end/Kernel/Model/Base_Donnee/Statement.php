<?php

namespace Kernel\Model\Base_Donnee;

use Kernel\INTENT\Intent;
use Kernel\Model\Base_Donnee\RUN;
use Kernel\Model\Base_Donnee\Schema;
use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Query\QuerySQL;
use TypeError;

class Statement extends RUN
{

    private $shema;

    public function __construct($PathConfigJsone, $table)
    {

        $this->shema = new Schema($PathConfigJsone);

        parent::__construct($PathConfigJsone, new EntitysDataTable(), $this->shema->getschema($table));
    }

    function getTable()
    {
        return $this->entitysSchema->getPARENT();
    }

    ////////////////////////////////////////////////////////////////////////////



    public function update($data, $condition)
    {

        return (new QuerySQL())
                        ->update($this->getTable())
                        ->set($data)
                        ->where($condition);
    }

    public function delete($condition)
    {



        return (new QuerySQL())
                        ->delete($condition)
                        ->from($this->getTable());
    }

    public function insert(array $dataForm, $mode): Intent
    {
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
    public function Select(array $mode, $condition): Intent
    {

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

    private function setDataJoins(array $Entitys, array $mode)
    {
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
    public function form(array $mode): Intent
    {
        $schema = $this->entitysSchema;
        $nameTable_FOREIGNs = $schema->getFOREIGN_KEY();

        $Entitys_FOREIGNs = [];
        foreach ($nameTable_FOREIGNs as $nameTable_FOREIGN) {
            $schem_Table_FOREIGN = $this->shema->getschema($nameTable_FOREIGN);

            $Entitys_FOREIGNs[$nameTable_FOREIGN] = $this->query((new QuerySQL())
                            ->select($schem_Table_FOREIGN->select_master())
                            ->from($schem_Table_FOREIGN->getPARENT())
                            ->join($schem_Table_FOREIGN->getFOREIGN_KEY()));
        }


        ////////////////////////////////////////////////////////////
        $nameTable_CHILDRENs = $schema->get_table_CHILDREN();
        $Entitys_CHILDRENs = [];

        foreach ($nameTable_CHILDRENs as $table_CHILDREN) {
            $schem_Table_CHILDREN = $this->shema->getschema($table_CHILDREN);

            $Entitys_CHILDRENs[$table_CHILDREN] = $this->query(((new QuerySQL())
                            ->select($schem_Table_CHILDREN->select_master())
                            ->from($schem_Table_CHILDREN->getPARENT())
                            ->join($schem_Table_CHILDREN->getFOREIGN_KEY())
                            ->independent($schema->getPARENT())));
        }

        $data = ["FOREIGN_KEYs" => $Entitys_FOREIGNs,
            "CHILDRENs" => $Entitys_CHILDRENs];

        return new Intent($schema, $data, $mode);
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
    
}
