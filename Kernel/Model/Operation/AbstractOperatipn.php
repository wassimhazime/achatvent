<?php
namespace Kernel\Model\Operation;

use Kernel\Model\Base_Donnee\MetaDatabase;
use Kernel\Model\Entitys\EntitysSchema;

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
    function getTable(): string
    {
        return $this->table;
    }
    
    function _getSchema(): EntitysSchema {
        return $this->schema;
    }


    
    
}
