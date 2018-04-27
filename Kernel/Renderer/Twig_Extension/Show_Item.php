<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Renderer\Twig_Extension;

use Exception;
use Kernel\html\ConfigExternal;
use Kernel\html\element\FormHTML;
use Kernel\html\element\ShowItem;
use Kernel\html\element\TableHTML;
use Kernel\INTENT\Intent;
use Kernel\Router\Router;
use Kernel\Tools\Tools;

class Show_Item extends \Twig_Extension
{

    private $ConfigExternal;

    public function __construct($PathConfigJsone)
    {
        $this->ConfigExternal = new ConfigExternal($PathConfigJsone);
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction("Show_Item", [$this, "Show_Item"], ['is_safe' => ['html']]),
        ];
    }

    public function Show_Item(Intent $intent)
    {
        if ($intent->getMode() != Intent::MODE_FORM) {
            throw new Exception("methode call  ERROR ==>  mode != MODE_FORM ");
        }

        $entitysDataTable = $intent->getEntitysDataTable();
        $old = $entitysDataTable["Default"];
        if ($old != []) {
            $DataJOIN = $old[0]->getDataJOIN();
            $DefaultData = Tools::entitys_TO_array($old[0]);

            $DefaultData["DataJOIN"] = $DataJOIN;
        } else {
            $DefaultData = [];
        }


        $Conevert = ($this->ConfigExternal->getConevert_TypeClomunSQL_to_TypeInputHTML());

        $COLUMNS_META_object = $intent->getEntitysSchema()->getCOLUMNS_META();




        $formhtml = new ShowItem($COLUMNS_META_object, $Conevert, $entitysDataTable, $DefaultData);

        return $formhtml->builder();
    }
}
