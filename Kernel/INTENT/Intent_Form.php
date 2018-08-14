<?php

/*
  kafrthaa hhhhhhhhhhh
 * i3adat nadar hona
 */

namespace Kernel\INTENT;

use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Tools\Tools;

/**
 * Description of Intent_Form
 *
 * @author wassime
 */
class Intent_Form {

    private $COLUMNS_META = [];
    private $Charge_data = [];
    private $Default_Data=[];

    function __construct(array $COLUMNS_META = []) {

        $this->setCOLUMNS_META($COLUMNS_META);
        $this->Default_Data["DataJOIN"] = [];
        $this->Charge_data["select"]=[];
        
        
    }

    function setCOLUMNS_META(array $COLUMNS_META) {
        $this->COLUMNS_META = Tools::entitys_TO_array($COLUMNS_META);
    }

    function setCharge_data(array $Charge_data) {
        if (!isset($Charge_data["select"])) {
            $Charge_data["select"] = [];
        }
        if (!isset($Charge_data["multiselect"])) {
            $Charge_data["multiselect"] = [];
        }

        $this->Charge_data = $Charge_data;
    }

    function setCharge_data_select(array $Charge_data_select) {

        $this->Charge_data["select"] = $this->DataJOIN($Charge_data_select);
    }

    function setCharge_data_multiSelect(array $Charge_data_multiSelect) {

        $this->Charge_data["multiselect"] = $this->DataJOIN($Charge_data_multiSelect);
    }

    function setDefault_Data(EntitysDataTable $Default_Data) {
        if ($Default_Data != []) {
            $DefaultData = Tools::entitys_TO_array($Default_Data);

            $DefaultData["DataJOIN"] = $this->DataJOIN($Default_Data->getDataJOIN());
        } 
        
        $this->Default_Data = $DefaultData;
    }

    private function DataJOIN(array $Default_Data): array {



        /*
          'clients' =>
          array (size=2)
          0 =>

          public 'clients_id' => string '206' (length=3)
          public 'clients_clients' => string 'achrafh hazime' (length=14)
          public 'clients_cin' => string 'AZ' (length=2)
         * 
         * 
         * to
          'clients' =>
          array (size=2)
          0 =>

          'id' => string '206' (length=3)
          'clients' => string 'achrafh hazime' (length=14)
          'cin' => string 'AZ' (length=2)
         * 
         * 
         */
        $Default_DataArray = [];

        foreach ($Default_Data as $nameTable => $dataTable) {

            foreach ($dataTable as $Entiti_data) {
                $Default_DataArray[$nameTable][] = (Tools::entitys_TO_array($Entiti_data, $nameTable));
            }
        }
        return $Default_DataArray;
    }

    function getCOLUMNS_META(): array {
        return $this->COLUMNS_META;
    }

    function getCharge_data(): array {

        return $this->Charge_data;
    }

    function getDefault_Data(): array {

        return $this->Default_Data;
    }

}
