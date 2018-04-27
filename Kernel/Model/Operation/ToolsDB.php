<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Model\Operation;

/**
 * Description of ToolsDB
 *
 * @author wassime
 */
class ToolsDB extends AbstractOperatipn
{

    public function is_Table(string $nameTable): bool
    {
        
        $entity = $this->getschema($nameTable);
        
     
        
        return $entity->getNameTable() != null;
    }
    
    public function getAllTables()
    {
        $names_Tables = [];
        $Schemas = $this->getALLschema();
        foreach ($Schemas as $schema) {
            $names_Tables[]=$schema->getNameTable();
        }

        return $names_Tables;
    }
}
