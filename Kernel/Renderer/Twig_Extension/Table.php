<?php

namespace Kernel\Renderer\Twig_Extension;

use Kernel\html\element\TableHTML;
use Kernel\INTENT\Intent_Show;
use Kernel\Tools\Tools;
use Twig_Extension;
use Twig_SimpleFunction;

class Table extends Twig_Extension {

    private $tablehtml;

    function __construct() {
        $this->tablehtml = new TableHTML();
    }

    public function getFunctions() {
        return [
            new Twig_SimpleFunction("table_intent", [$this, "table_intent"], ['is_safe' => ['html']]),
            new Twig_SimpleFunction("table_array", [$this, "table_array"], ['is_safe' => ['html']]),
            new Twig_SimpleFunction("table_json_intent", [$this, "table_json_intent"], ['is_safe' => ['html']])
        ];
    }

    public function table_intent(Intent_Show $intent, array $input = []) {



        $metaTableHTML = Tools::intent_to_metaTableHTML($intent);

        $columns = $metaTableHTML["columns"];
        $DataTable = $metaTableHTML["DataTable"];
        $CHILD = $metaTableHTML["CHILD"];

        return $this->tablehtml->builder($columns, $DataTable, $CHILD, $input);
    }

    public function table_array(array $columns, array $DataTable, array $CHILD = [], array $input = []) {
        return $this->tablehtml->builder($columns, $DataTable, $CHILD, $input);
    }

    public function table_json_intent(Intent_Show $intent) {


        $entity = ($intent->getEntitysDataTable());
        $data = Tools::entitys_TO_array($entity);

        $titles = [];
        $dataSets = [];
        foreach ($data as $rom) {
            $title = [];
            $dataSet = [];
            foreach ($rom as $t => $d) {
                $title[] = ["title" => $t];
                $dataSet[] = $d;
            }
            $titles = $title;
            $dataSets[] = $dataSet;
        }

        return Tools::json(["data" => $data, "titles" => $titles, "dataSet" => $dataSets]);
    }

}
