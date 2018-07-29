<?php

namespace Kernel\Model;

use Kernel\Model\Operation\GetData;
use Kernel\Model\Operation\GUI;
use Kernel\Model\Operation\SetData;
use Kernel\Model\Operation\Statistique;
use Kernel\Model\Operation\ToolsDB;

class Model {

    private $table = null;
  
    private $is_null = true;
    private $PathJsonConfig;
    private $ToolsDB;

    public function __construct($PathJsonConfig) {
        $this->PathJsonConfig = $PathJsonConfig;
        $this->ToolsDB = new ToolsDB($PathJsonConfig);
    }

    public function is_null(): bool {
        return $this->is_null;
    }

    public function setTable(string $table): bool {
        $this->is_null = !$this->ToolsDB->is_Table($table);

        if (!$this->is_null) {
            $this->table = $table;
        }
        return !$this->is_null;
    }

    public function getToolsDB(): ToolsDB {
        return $this->ToolsDB;
    }

    public function getAllTables(): array {
        return $this->getToolsDB()->getAllTables();
    }

    public function getTable(): string {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setTable()");
        }
        return $this->table;
    }

    public function get_setData(): SetData {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setTable()");
        }

        return new SetData($this->PathJsonConfig, $this->table);
    }

    public function getGui(): GUI {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setTable()");
        }
        return new GUI($this->PathJsonConfig, $this->table);
    }

    public function getData(): GetData {
        if ($this->is_null()) {
            throw new TypeError(" set table ==> call function setTable()");
        }

        return new GetData($this->PathJsonConfig, $this->table);
    }

    public function action(string $action) {
        if ($action == "statistique") {
            return new Statistique($this->PathJsonConfig);
        } else {
            throw new TypeError(" not acition in model ");
        }
    }

}
