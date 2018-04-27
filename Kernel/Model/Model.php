<?php

namespace Kernel\Model;

use Kernel\Model\Operation\GetData;
use Kernel\Model\Operation\GUI;
use Kernel\Model\Operation\SetData;
use Kernel\Model\Operation\Statistique;
use Kernel\Model\Operation\ToolsDB;

class Model
{

    protected $setData = null;
    protected $table = null;
    protected $gui = null;
    protected $getData = null;
    protected $statistique = null;
    protected $is_null = true;
    protected $PathJsonConfig;
    protected $ToolsDB;

    public function __construct($PathConfigJsone)
    {
        $this->PathJsonConfig = $PathConfigJsone;
        $this->ToolsDB = new ToolsDB($PathConfigJsone);
    }

    function setStatement($table)
    {

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
    
    public function getAllTables()
    {
        return $this->ToolsDB->getAllTables();
    }
}
