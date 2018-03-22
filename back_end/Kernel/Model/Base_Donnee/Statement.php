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
    public function update(array $dataForm, $mode): int
    {
        if ($mode != Intent::MODE_UPDATE) {
            throw new TypeError(" ERROR mode Intent ==> mode!= MODE_UPDATE ");
        }

        $intent = Intent::parse($dataForm, $this->entitysSchema, $mode);

        $dataCHILDRENs = $this->charge_data_childe($intent);
        $data_parent = $this->remove_childe_in_data($intent);
        $id_parent = $data_parent["id"];

        unset($data_parent["id"]);   // remove id
        // exec query sql insert to parent table
        $querySQL = (new QuerySQL())->
                update($this->getTable())
                ->set($data_parent)
                ->where("id=$id_parent")
                ->query();
        $this->exec($querySQL);


        /**
         * code delete insert  data to relation table
         */
        //delete
        $this->delete_data_childe($intent, $id_parent);
        //insert
        $this->insert_data_childe($intent, $id_parent, $dataCHILDRENs);

        return $id_parent;
    }

    public function delete($condition)
    {
        $delete = (new QuerySQL())
                ->delete($condition)
                ->from($this->getTable());
        $this->exec($delete);
    }

    public function insert(array $dataForm, $mode): int
    {

        if ($mode != Intent::MODE_INSERT) {
            throw new TypeError(" ERROR mode Intent ==> mode!= MODE_INSERT ");
        }

        $intent = Intent::parse($dataForm, $this->entitysSchema, $mode);
        $dataCHILDRENs = $this->charge_data_childe($intent);
        $data_parent = $this->remove_childe_in_data($intent);
        unset($data_parent["id"]);   // remove id
        // exec query sql insert to parent table

        $querySQL = (new QuerySQL())
                ->insertInto($this->getTable())
                ->value($data_parent);
        // return id rowe set data parent table
        $id_parent = $this->exec($querySQL);

        /**
         * code insert data to relation table
         */
        $this->insert_data_childe($intent, $id_parent, $dataCHILDRENs);


        return $id_parent;
    }

////////////////////////////////////////////////////////////////////////////////

    /**
     *
      charge data variables
     */
    private function charge_data_childe($intent)
    {
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

    private function remove_childe_in_data($intent)
    {
        $data = ($intent->getEntitysDataTable()[0]);
        $name_CHILDRENs = (array_keys($intent->getEntitysSchema()->getCHILDREN())); // name childern array

        foreach ($name_CHILDRENs as $name_CHILDREN) {
            if (isset($data->$name_CHILDREN)) {
                unset($data->$name_CHILDREN); // remove CHILDREN in $data
            }
        }
        return Intent::entitys_TO_array($data);
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     *
      exec SQL des tables relations
     */
    private function insert_data_childe($intent, $id_parent, $dataCHILDRENs)
    {
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

    private function delete_data_childe($intent, $id_parent)
    {

        $name_CHILDRENs = (array_keys($intent->getEntitysSchema()->getCHILDREN())); // name childern array
        foreach ($name_CHILDRENs as $name_table_CHILDREN) {
            $sqlquery = (new QuerySQL())
                    ->delete(["id_" . $intent->getEntitysSchema()->getPARENT() => $id_parent])
                    ->from("r_" . $intent->getEntitysSchema()->getPARENT() . "_" . $name_table_CHILDREN)
                    ->query();
            $this->exec($sqlquery);
        }
    }
}
