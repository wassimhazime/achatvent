<?php

namespace Kernel\Model;

use Kernel\Model\Operation\GetData;
use Kernel\Model\Operation\GUI;
use Kernel\Model\Operation\SetData;
use Kernel\Model\Operation\Statistique;
use Kernel\Model\Operation\ToolsDB;

class Model {

    private $setData = null;
    private $table = null;
    private $gui = null;
    private $getData = null;
    private $statistique = null;
    private $is_null = true;
    private $PathJsonConfig;
    private $ToolsDB;

    public function __construct($PathConfigJsone) {
        $this->PathJsonConfig = $PathConfigJsone;
        $this->ToolsDB = new ToolsDB($PathConfigJsone);
    }

    public function is_null(): bool {
        return $this->is_null;
    }

    public function showAjax($mode, $condition) {
        if ($this->is_null()) {
            throw new TypeError(" is_null==> show ");
        }

        $intent = $this->getData()->select($mode, $condition);
        $entity = ($intent->getEntitysDataTable());

        return \Kernel\Tools\Tools::entitys_TO_array($entity);
    }

    public function setStatement(string $table) {
        if ($table == "statistique") {
            return new Statistique($this->PathJsonConfig);
        } else {
            if ($this->ToolsDB->is_Table($table)) {
                $this->is_null = false;
                $this->table = $table;
                $this->setData = new SetData($this->PathJsonConfig, $table);
                $this->gui = new GUI($this->PathJsonConfig, $table);
                $this->getData = new GetData($this->PathJsonConfig, $table);
            }
        }
    }

    public function getAllTables() {
        return $this->ToolsDB->getAllTables();
    }

    public function get_setData(): SetData {
        return $this->setData;
    }

    public function getTable(): string {
        return $this->table;
    }

    public function getGui(): GUI {
        return $this->gui;
    }

    public function getData(): GetData {
        return $this->getData;
    }

    public function getStatistique(): Statistique {
        return $this->statistique;
    }

    public function getToolsDB(): ToolsDB {
        return $this->ToolsDB;
    }

    //////////////////////////////
    public function delete($condition) {

        return $this->get_setData()->delete($condition);
    }

    public function show_in(array $mode, $condition = true) {
        if ($this->is_null()) {
            throw new TypeError(" is_null==> show ");
        }
        if ($condition !== true) {
            $condition = explode(",", $condition);
        }
        $intent = $this->getData()->select_in($mode, "{$this->getTable()}.id", $condition);
        return $intent;
    }

    public function formSelect() {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }
        $intent = $this->getGui()->formSelect();
        return $intent;
    }

    public function formDefault($conditon) {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }

        $intent = $this->getGui()->formDefault($conditon);


        return $intent;
    }

    public function form($conditon = "") {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setStatement() ");
        }

        $intent = $this->getGui()->form($conditon);


        return $intent;
    }

    public function show_id($id) {
        return $this->getGui()->formDefault(["{$this->getTable()}.id" => $id]);
    }

}
