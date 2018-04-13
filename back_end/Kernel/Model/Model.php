<?php

namespace Kernel\Model;

use Kernel\INTENT\Intent;
use Kernel\Model\Operation\GUI;
use Kernel\Model\Operation\GetData;
use Kernel\Model\Operation\SetData;
use Kernel\Model\Operation\Statistique;
use TypeError;

class Model {

    private $setData = null;
    private $table = null;
    private $gui = null;
    private $getData = null;
    private $statistique = null;
    private $is_null = true;
    private $PathJsonConfig;

    public function __construct($PathConfigJsone) {
        $this->PathJsonConfig = $PathConfigJsone;
    }

    function setStatement($table) {
        if ($table == "statistique") {
            $this->statistique = new Statistique($this->PathJsonConfig);
            return  $this->statistique->statistique_par();
            

         
        } else {
            $this->is_null = false;
            $this->table = $table;
            $this->setData = new SetData($this->PathJsonConfig, $table);
            $this->gui = new GUI($this->PathJsonConfig, $table);
            $this->getData = new GetData($this->PathJsonConfig, $table);
        }
    }
    

    public function setData($data): Intent {
        if ($this->is_null) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }
        if (isset($data) && !empty($data)) {

            unset($data["ajout_data"]);

            if ($data['id'] == "") {
                $id_parent = $this->setData->insert($data, Intent::MODE_INSERT);
            } else {
                $id_parent = $this->setData->update($data, Intent::MODE_UPDATE);
            }


            return $this->getData->select(Intent::MODE_SELECT_ALL_ALL, "{$this->table}.id=$id_parent");
        } else {
            die("rak 3aya9ti");
        }
    }

    public function delete($condition) {

        $intent = $this->setData->delete($condition);

        return $intent;
    }

    public function show(array $mode, $condition): Intent {
        if ($this->is_null) {
            throw new TypeError(" is_null==> show ");
        }
        $intent = $this->getData->select($mode, $condition);
        return $intent;
    }

    public function form(array $mode, $conditon = ""): Intent {
        if ($this->is_null) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }

        $intent = $this->gui->form($mode, $conditon);


        return $intent;
    }

    public function formDefault(array $mode, $conditon = ""): Intent {
        if ($this->is_null) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }

        $intent = $this->gui->formDefault($mode, $conditon);


        return $intent;
    }

    public function formSelect(array $mode): Intent {
        if ($this->is_null) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }
        $intent = $this->gui->formSelect($mode);
        return $intent;
    }

    function is_null() {
        return $this->is_null;
    }

//statistique
    public function Facture_achat_HT($date) {
        
    }

    public function Facture_vente_HT($date) {
        
    }

    public function Avoirs_HT($date) {
        
    }

    public function Depenses($date) {
        
    }

    public function Recettes($date) {
        
    }

    public function Creances($date) {
        
    }

    public function Dettes($date) {
        
    }

    public function TVA_collectee($date) {
        
    }

    public function TVA_deductible($date) {
        
    }

    public function TVA_due($date) {
        
    }

}
