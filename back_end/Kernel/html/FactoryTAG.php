<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html;

use Kernel\html\ConfigExternal;
use Kernel\html\element\FormHTML;
use Kernel\html\element\TableHTML;
use Kernel\INTENT\Intent;

/**
 * Description of TAG
 *
 * Les décorateurs
 */
class FactoryTAG
{

    private $ConfigExternal;

    public function __construct($PathConfigJsone)
    {


        $this->ConfigExternal = new ConfigExternal($PathConfigJsone);
    }

    //"nette/forms": "^2.4",
    public function tableHTML(Intent $intent)
    {
        $input = ["title" => 'Controle',
            "body" => '<spam style="display: inline-block;    width: max-content;">'
            . '<a class="btn btn-danger  "   href="?supprimer=index" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>'
            . '<a class="btn btn-success"    href="?modifier=index" ><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>'
            . '</spam>'
        ];

        $tablehtml = new TableHTML($intent);
        $schema = $intent->getEntitysSchema();

        $COLUMNS_master = $schema->getCOLUMNS_master();
        $COLUMNS_all = $schema->getCOLUMNS_all();
        $COLUMNS_default = $schema->getCOLUMNS_default();
        $FOREIGN_KEY = $schema->getFOREIGN_KEY();

        $table = $intent->getEntitysDataTable();

        if (Intent::is_show_MASTER($intent)) {
            $columns = array_merge($COLUMNS_master, $FOREIGN_KEY);
        } elseif (Intent::is_show_ALL($intent)) {
            $columns = array_merge($COLUMNS_all, $FOREIGN_KEY);
        }elseif (Intent::is_show_DEFAULT($intent)) {
            $columns = array_merge($COLUMNS_default, $FOREIGN_KEY);
        }
       
        $columns = array_merge($columns, [$input["title"]]);


        $CHILD = [];
        $CHILD["flag_show_CHILDREN"] = Intent::is_get_CHILDREN($intent);

        if ($CHILD["flag_show_CHILDREN"]) {
            $CHILD["table_CHILDREN"] = $schema->get_table_CHILDREN(); // le nom de la table
            $CHILD["CHILDREN"] = $schema->getCHILDREN(); // les noms des champ
            $CHILD["datajoins"] = [];  //// body
            foreach ($table as $value) {
                $CHILD["datajoins"][] = $value->getDataJOIN();
            }

            $columns = array_merge($columns, $CHILD["table_CHILDREN"]);  ///head
        }

        ////////////////////////////

        return $tablehtml->builder('id="example" class="table table-striped table-bordered dt-responsive nowrap"', $columns, $table, $input["body"], $CHILD);
    }

    public function FormHTML(Intent $intent)
    {
        if ($intent->getMode() != Intent::MODE_FORM) {
            throw new \Exception("methode call  ERROR ==>  mode != MODE_FORM ");
        }
      
        $entitysDataTable = $intent->getEntitysDataTable();
        $old=$entitysDataTable["Default"];
        if ($old !=[]) {
            $DataJOIN=$old[0]->getDataJOIN();
            $DefaultData= \Kernel\Tools\Tools::entitys_TO_array($old[0]);
            
            $DefaultData["DataJOIN"]=$DataJOIN;
        } else {
            $DefaultData=[];
        }

        
        $Conevert = ($this->ConfigExternal->getConevert_TypeClomunSQL_to_TypeInputHTML());
     
        $COLUMNS_META_object = $intent->getEntitysSchema()->getCOLUMNS_META();

        
       
        
        $formhtml = new FormHTML($COLUMNS_META_object, $Conevert, $entitysDataTable, $DefaultData);
        
        return $formhtml->builder();
    }

    public function message(Intent $intent)
    {

        return $this->tableHTML($intent);
    }
}
