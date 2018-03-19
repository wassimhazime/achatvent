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
}
