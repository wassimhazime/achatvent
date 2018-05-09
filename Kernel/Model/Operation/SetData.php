<?php

namespace Kernel\Model\Operation;

use Kernel\INTENT\Intent;
use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Entitys\EntitysSchema;
use Kernel\Model\Query\QuerySQL;
use Kernel\Tools\Tools;
use TypeError;

class SetData extends AbstractOperatipn
{

    public function update(array $dataForm, $mode): int
    {
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
                ->where("id=$id_NameTable")
                ->query();
        $this->exec($querySQL);


        /**
         * code delete insert  data to relation table
         */
        //delete
        $this->delete_data_childe($intent, $id_NameTable);
        //insert
        $this->insert_data_childe($intent, $id_NameTable, $dataCHILDRENs);

        return $id_NameTable;
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
                ->value($data_NameTable);
        // return id rowe set data NameTable table
        $id_NameTable = $this->exec($querySQL);

        /**
         * code insert data to relation table
         */
        
       
        
        $this->insert_data_childe($intent, $id_NameTable, $dataCHILDRENs);


        return $id_NameTable;
    }

    
     public function insert_inverse(array $dataForms,$id_parent ,$mode): int
    {
         
         
        if ($mode != Intent::MODE_INSERT) {
            throw new TypeError(" ERROR mode Intent ==> mode!= MODE_INSERT ");
        }
        $id_cheldrns=[];
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
                ->value($data_NameTable);
        // return id rowe set data NameTable table
        $id_cheldrns[] = $this->exec($querySQL);
            
        }
        var_dump($id_cheldrns,$id_parent);
        
        foreach ($id_cheldrns as $id_cheld) {
            
            
              $querySQL = (new QuerySQL())->
                        insertInto("r_achats_achat")
                        ->value([
                    "id_achats"  => $id_parent,
                    "id_achat"  => $id_cheld
                        ]);

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
        return Tools::entitys_TO_array($data);
    }

    ////////////////////////////////////////////////////////////////////////////

    /**
     *
      exec SQL des tables relations
     */
    private function insert_data_childe($intent, $id_NameTable, $dataCHILDRENs)
    {
        foreach ($dataCHILDRENs as $name_table_CHILDREN => $id_CHILDRENs) {
            foreach ($id_CHILDRENs as $id_CHILD) {
                $querySQL = (new QuerySQL())->
                        insertInto("r_" . $intent->getEntitysSchema()->getNameTable() . "_" . $name_table_CHILDREN)
                        ->value([
                    "id_" . $intent->getEntitysSchema()->getNameTable() => $id_NameTable,
                    "id_" . $name_table_CHILDREN => $id_CHILD
                        ]);

                $this->exec($querySQL);
            }
        }
    }

    private function delete_data_childe($intent, $id_NameTable)
    {

        $name_CHILDRENs = (array_keys($intent->getEntitysSchema()->getCHILDREN())); // name childern array
        foreach ($name_CHILDRENs as $name_table_CHILDREN) {
            $sqlquery = (new QuerySQL())
                    ->delete(["id_" . $intent->getEntitysSchema()->getNameTable() => $id_NameTable])
                    ->from("r_" . $intent->getEntitysSchema()->getNameTable() . "_" . $name_table_CHILDREN)
                    ->query();
            $this->exec($sqlquery);
        }
    }

    /////////////////////////////
    /// insert update
    private function parse(array $data, EntitysSchema $schema, array $mode): Intent
    {
        if (Tools::isAssoc($data) and isset($data)) {
            return (new Intent($schema, ((new EntitysDataTable())->set($data)), $mode));
        }
    }
}
