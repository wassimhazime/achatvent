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
            "body" => '<a class="btn btn-default"  role="button" href="?supprimer=index" >supprimer</a>'
            . '<a class="btn btn-default"  role="button" href="?modifier=index" >modifier</a>'
        ];

        $tablehtml = new TableHTML($intent);
        $schema = $intent->getEntitysSchema();

        $COLUMNS_master = $schema->getCOLUMNS_master();
        $COLUMNS_all = $schema->getCOLUMNS_all();
        $FOREIGN_KEY = $schema->getFOREIGN_KEY();

        $table = $intent->getEntitysDataTable();

        if (Intent::is_PARENT_MASTER($intent)) {
            $columns = array_merge($COLUMNS_master, $FOREIGN_KEY);
        } elseif (Intent::is_PARENT_ALL($intent)) {
            $columns = array_merge($COLUMNS_all, $FOREIGN_KEY);
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

        return $tablehtml->builder("class='table table-hover table-bordered' style='width:100%'", $columns, $table, $input["body"], $CHILD);
    }

    public function FormHTML(Intent $intent, $oldData = null)
    {
        if ($intent->getMode() != Intent::MODE_FORM) {
            throw new \Exception("methode call  ERROR ==>  mode != MODE_FORM ");
        }
        if ($oldData !== null) {
            $old=$oldData->getEntitysDataTable();
            $DataJOIN=$old[0]->getDataJOIN();
            $DefaultData = json_decode(json_encode($old[0]), true);
            $DefaultData["DataJOIN"]=$DataJOIN;
        } else {
            $DefaultData=[];
        }

        $Conevert = ($this->ConfigExternal->getConevert_TypeClomunSQL_to_TypeInputHTML());
        $entitysDataTable = $intent->getEntitysDataTable();
        $COLUMNS_META_object = $intent->getEntitysSchema()->getCOLUMNS_META();

        $formhtml = new FormHTML($COLUMNS_META_object, $Conevert, $entitysDataTable, $DefaultData);
        
        return $formhtml->builder();
    }

    public function message(Intent $intent)
    {

        return $this->tableHTML($intent);
    }
}
