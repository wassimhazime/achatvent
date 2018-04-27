<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html;

use Exception;
use Kernel\html\ConfigExternal;
use Kernel\html\element\FormHTML;
use Kernel\html\element\ShowItem;
use Kernel\html\element\TableHTML;
use Kernel\INTENT\Intent;
use Kernel\Router\Router;
use Kernel\Tools\Tools;

/**
 * Description of TAG
 *
 * Les décorateurs
 */
 //"nette/forms": "^2.4",
class FactoryTAG
{

    private $ConfigExternal;

    public function __construct($PathConfigJsone)
    {
        $this->ConfigExternal = new ConfigExternal($PathConfigJsone);
    }

//   
//    public function tableHTML(Intent $intent, string $attrHtml, array$input) {
//        
//
//        $metaTableHTML = Tools::intent_to_metaTableHTML($intent);
//        $columns=$metaTableHTML["columns"]; 
//        $table=$metaTableHTML["table"]; 
//        $CHILD=$metaTableHTML["CHILD"];
//        $tablehtml = new TableHTML();
//        return $tablehtml->builder(  $columns, $table, $CHILD,$attrHtml, $input );
//    }
//
//    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    public function FormHTML(Intent $intent)
    {
//        if ($intent->getMode() != Intent::MODE_FORM) {
//            throw new Exception("methode call  ERROR ==>  mode != MODE_FORM ");
//        }
//
//        $entitysDataTable = $intent->getEntitysDataTable();
//        $old = $entitysDataTable["Default"];
//        if ($old != []) {
//            $DataJOIN = $old[0]->getDataJOIN();
//            $DefaultData = Tools::entitys_TO_array($old[0]);
//
//            $DefaultData["DataJOIN"] = $DataJOIN;
//        } else {
//            $DefaultData = [];
//        }
//
//
//        $Conevert = ($this->ConfigExternal->getConevert_TypeClomunSQL_to_TypeInputHTML());
//
//        $COLUMNS_META_object = $intent->getEntitysSchema()->getCOLUMNS_META();
//
//
//
//
//        $formhtml = new FormHTML($COLUMNS_META_object, $Conevert, $entitysDataTable, $DefaultData);
//
//        return $formhtml->builder();
    }

    
    
    
    
    
    
    public function showinfo(Intent $intent)
    {
//        if ($intent->getMode() != Intent::MODE_FORM) {
//            throw new Exception("methode call  ERROR ==>  mode != MODE_FORM ");
//        }
//
//        $entitysDataTable = $intent->getEntitysDataTable();
//        $old = $entitysDataTable["Default"];
//        if ($old != []) {
//            $DataJOIN = $old[0]->getDataJOIN();
//            $DefaultData = Tools::entitys_TO_array($old[0]);
//
//            $DefaultData["DataJOIN"] = $DataJOIN;
//        } else {
//            $DefaultData = [];
//        }
//
//
//        $Conevert = ($this->ConfigExternal->getConevert_TypeClomunSQL_to_TypeInputHTML());
//
//        $COLUMNS_META_object = $intent->getEntitysSchema()->getCOLUMNS_META();
//
//
//
//
//        $formhtml = new ShowItem($COLUMNS_META_object, $Conevert, $entitysDataTable, $DefaultData);
//
//        return $formhtml->builder();
    }

    public function message(Intent $intent, Router $router, $nameRoute)
    {

//        return $this->tableHTML($intent, $router, $nameRoute);
    }
}
