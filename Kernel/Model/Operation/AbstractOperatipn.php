<?php
namespace Kernel\Model\Operation;

use Kernel\Model\Base_Donnee\MetaDatabase;

/**
 * Description of abstractOperatipn
 *
 * @author wassime
 */

abstract class AbstractOperatipn extends MetaDatabase
{

    private $table;
    protected $schema;

    public function __construct($PathConfigJsone, $table = null)
    {
        parent::__construct($PathConfigJsone);
        if ($table != null) {
            $this->table = $table;
            $this->schema = $this->getschema($table);
        }
    }
    function getTable()
    {
        return $this->table;
    }
}
