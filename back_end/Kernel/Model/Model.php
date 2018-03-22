<?php

namespace Kernel\Model;

use Kernel\INTENT\Intent;
use Kernel\Model\Base_Donnee\Statement;
use Kernel\Model\Base_Donnee\FORM;
use Kernel\Model\Base_Donnee\Select;
use TypeError;

class Model
{

    private $statement = null;
    private $table = null;
    private $form = null;
    private $select = null;
    private $is_null = true;
    private $PathJsonConfig;

    public function __construct($PathConfigJsone)
    {
        $this->PathJsonConfig = $PathConfigJsone;
    }

    function setStatement($table)
    {
        $this->is_null = false;
        $this->table = $table;
        $this->statement = new Statement($this->PathJsonConfig, $table);
        $this->form = new FORM($this->PathJsonConfig, $table);
        $this->select = new Select($this->PathJsonConfig, $table);
    }

    public function setData($data, $mode): Intent
    {
        if ($this->is_null) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }
        if (isset($data) && !empty($data)) {
            unset($data["ajout_data"]);
            
            if ($mode== Intent::MODE_INSERT) {
                $id_parent = $this->statement->insert($data, $mode);
            } elseif ($mode== Intent::MODE_UPDATE) {
                $id_parent = $this->statement->update($data, $mode);
            }
               

            return $this->select->select(Intent::MODE_SELECT_ALL_ALL, "{$this->table}.id=$id_parent");
        } else {
            throw new TypeError(" ERROR setData(data) model  ==> data null");
        }
    }

    public function delete($condition)
    {

        $intent = $this->statement->delete($condition);

        return $intent;
    }

    public function show(array $mode, $condition): Intent
    {
        if ($this->is_null) {
            throw new TypeError(" is_null==> show ");
        }
        $intent = $this->select->select($mode, $condition);
        return $intent;
    }

    public function form(array $mode, $conditon = ""): Intent
    {
        if ($this->is_null) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }

        $intent = $this->form->form($mode, $conditon);


        return $intent;
    }

    public function formDefault(array $mode, $conditon = ""): Intent
    {
        if ($this->is_null) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }

        $intent = $this->form->formDefault($mode, $conditon);


        return $intent;
    }

    public function formSelect(array $mode): Intent
    {
        if ($this->is_null) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }
        $intent = $this->form->formSelect($mode);
        return $intent;
    }

    function is_null()
    {
        return $this->is_null;
    }
}
