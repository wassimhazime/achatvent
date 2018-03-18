<?php

namespace Kernel\Model\Entitys;

class EntitysSchema extends abstractEntitys {

    private $modeCHILDREN = null;
    private $PARENT = null;
    private $COLUMNS_META = [];
    private $COLUMNS_master = ["*"];
    private $COLUMNS_all = ["*"];
    private $FOREIGN_KEY = [];
    private $CHILDREN = [];

    public function Instance(array $table): self {
        $this->PARENT = $table["PARENT"];
        $this->COLUMNS_master = $table["COLUMNS_master"];
        $this->COLUMNS_all = $table["COLUMNS_all"];
        $this->COLUMNS_META = $table["COLUMNS_META"];
        $this->FOREIGN_KEY = $table["FOREIGN_KEY"];
        $this->CHILDREN = $table["CHILDREN"];

        return $this;
    }

    /*
     * modeCHILDREN
     */

    private function setModeCHILDREN($mode) {
        if ($mode == null and $this->modeCHILDREN == null) {
            $this->modeCHILDREN = "MASTER";
        } elseif ($mode != null) {
            $this->modeCHILDREN = $mode;
        }
    }

    /*
     * PARENT
     */

    function getPARENT() {
        return $this->PARENT;
    }

    function setPARENT($PARENT) {
        $this->PARENT = $PARENT;
    }

    /**
     *
     * COLUMNS
     */
    /// get columns meta total ou par type exemple  getCOLUMNS_META(["Key" =>"MUL"])
    function getCOLUMNS_META(array $key = []) {
        if (empty($key)) {
            return $this->COLUMNS_META;
        } else {
            if ($this->isAssoc($key)) {
                $COLUMNS_META = $this->COLUMNS_META;
                $COLUMNS_META_select = [];
                foreach ($key as $k => $v) {
                    foreach ($COLUMNS_META as $COLUMNS) {
                        if ($COLUMNS[$k] == $v) {
                            $COLUMNS_META_select[] = $COLUMNS;
                        }
                    }
                }
                return $COLUMNS_META_select;
            } else {
                return [];
            }
        }
    }

    function setCOLUMNS_META($COLUMNS_META) {
        $this->COLUMNS_META = $COLUMNS_META;
    }

    function getCOLUMNS_all() {
        return $this->COLUMNS_all;
    }

    function setCOLUMNS_all($COLUMNS_all) {
        $this->COLUMNS_all = $COLUMNS_all;
    }

    function getCOLUMNS_master() {
        return $this->COLUMNS_master;
    }

    function setCOLUMNS_master($COLUMNS) {
        $this->COLUMNS_master = $COLUMNS;
    }

    /**
     *
     * FOREIGN_KEY
     */
    function getFOREIGN_KEY() {
        return $this->FOREIGN_KEY;
    }

    function setFOREIGN_KEY($FOREIGN_KEY) {
        $this->FOREIGN_KEY = $FOREIGN_KEY;
    }

    /*
     * CHILDREN
     */

    function getCHILDREN($mode = null) {
        $this->setModeCHILDREN($mode);

        return $this->CHILDREN[$this->modeCHILDREN];
    }

    function get_table_CHILDREN($mode = null) {
        $this->setModeCHILDREN($mode);
        $TABLE = [];
        foreach ($this->CHILDREN[$this->modeCHILDREN] as $table => $columns) {
            $TABLE[] = $table;
        }

        return $TABLE;
    }

    function setCHILDREN($CHILDREN) {

        $this->CHILDREN = $CHILDREN;
    }

///TOULS
    /*
     * SELECT SQL
     */


    public function select_master() {

        $select = [];
        foreach ($this->COLUMNS_master as $colom) {
            $select[] = $this->PARENT . "." . $colom;
        }
//        foreach ($this->FOREIGN_KEY as $FOREIGN) {
//            $select[] = $FOREIGN . "." . $FOREIGN;
//        }
        return $select;
    }

    public function select_all() {

        $select = [];
        foreach ($this->COLUMNS_all as $colom) {
            $select[] = $this->PARENT . "." . $colom;
        }
        foreach ($this->FOREIGN_KEY as $FOREIGN) {
            $select[] = $FOREIGN . "." . $FOREIGN;
        }
        return $select;
    }

    public function select_FOREIGN_KEY(array $FOREIGN_KEY = null) {
        $select = [];
        if ($FOREIGN_KEY == null) {
            $FOREIGN_KEY = $this->FOREIGN_KEY;
        }
        foreach ($FOREIGN_KEY as $FOREIGN) {
            $select[] = $FOREIGN . "." . $FOREIGN;
        }

        return $select;
    }

    public function select_CHILDREN($TABLE = null, $mode = null) {
        $this->setModeCHILDREN($mode);
        $select = [];

        if ($TABLE == null) {
            foreach ($this->CHILDREN[$this->modeCHILDREN] as $table => $colums) {
                foreach ($colums as $colum) {
                    $select[] = $table . "." . $colum . " as $table" . "_" . $colum;
                }
            }
        } else {
            foreach ($this->CHILDREN[$this->modeCHILDREN][$TABLE] as $colum) {
                $select[] = $TABLE . "." . $colum . " as $TABLE" . "_" . $colum;
            }
        }




        return $select;
    }

}
