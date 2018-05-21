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

    function is_null(): bool {
        return $this->is_null;
    }

    function setStatement(string $table) {

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

    function get_setData(): SetData {
        return $this->setData;
    }

    function getTable(): string {
        return $this->table;
    }

    function getGui(): GUI {
        return $this->gui;
    }

    function getData(): GetData {
        return $this->getData;
    }

    function getStatistique(): Statistique {
        return $this->statistique;
    }

    function getToolsDB(): ToolsDB {
        return $this->ToolsDB;
    }

}
