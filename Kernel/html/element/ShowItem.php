<?php

namespace Kernel\html\element;

use Kernel\html\HTML;
use Kernel\Tools\Tools;

class ShowItem
{

    protected $input = [];
    protected $Conevert_TypeClomunSQL_to_TypeInputHTML;

    function __construct($COLUMNS_META_object, array $Conevert_TypeClomunSQL_to_TypeInputHTML, $entitysDataTable, $DefaultData = [])
    {


        $COLUMNS_META = Tools::entitys_TO_array($COLUMNS_META_object);

        $this->Conevert_TypeClomunSQL_to_TypeInputHTML = $Conevert_TypeClomunSQL_to_TypeInputHTML;
        //// change type sql to type html

        foreach ($COLUMNS_META as $COLUMN_META) {
            $COLUMN_META['Type'] = ($this->conevert_TypeClomunSQL_to_TypeInputHTML($COLUMN_META['Type']));
            $this->input[$COLUMN_META["Field"]] = $COLUMN_META;
            if (isset($DefaultData[$COLUMN_META["Field"]])) {
                $this->input[$COLUMN_META["Field"]] ['Default'] = $DefaultData[$COLUMN_META['Field']];
            }

            if ($COLUMN_META["Key"] == "MUL") {
                $DataFOREIGN_KEY = $entitysDataTable["FOREIGN_KEYs"][$COLUMN_META["Field"]];
                $this->input[$COLUMN_META["Field"]]["Data_load"] = $DataFOREIGN_KEY;
            }
        }
        foreach ($entitysDataTable["CHILDRENs"] as $name_CHILDREN => $data) {
            $default = [];
            if (isset($DefaultData['DataJOIN'][$name_CHILDREN])) {
                $default = $DefaultData['DataJOIN'][$name_CHILDREN];
            }

            $this->input[$name_CHILDREN] = [
                "Field" => $name_CHILDREN,
                "Type" => "multiSelect",
                "Null" => "YES",
                "Key" => "",
                "Default" => $default,
                "Extra" => "",
                "Data_load" => $data];
        }
    }

    private function conevert_TypeClomunSQL_to_TypeInputHTML(string $Type): string
    {

        $Conevert = $this->Conevert_TypeClomunSQL_to_TypeInputHTML;

        if (isset($Conevert[$Type])) {
            return $Conevert[$Type];
        } else {
            return "text";
        }
    }

    public function builder()
    {


        $INPUT = [];

        foreach ($this->input as $input) {
            switch ($input['Type']) {
                case "select":
                    $inputHTML = $this->selectTage($input);
                    break;
                case "multiSelect":
                    $inputHTML = $this->multiSelectTag($input);
                    break;
                default:
                    $inputHTML = $this->pTage($input);
                    break;
            }

            $labelHTML = $this->labelTage($input);
            $INPUT[] = HTML::TAG("div")
                    ->setClass("row form-group")
                    ->setData([$labelHTML, $inputHTML])
                    ->builder();
        }

        $builder = implode("\n", $INPUT);

        return $builder;
    }

    public function selectTage(array $input): string
    {
        $name = $input['Field'];
      
            
         $data_load = Tools::entitys_TO_array($input['Data_load'][0]);
      

        /// spam attrdata
        $infocontent = "";
        $tokens = "";
        foreach ($data_load as $column => $value) {
            $infocontent .= $column . '$$$' . $value . ' £££ ';
            $tokens .= $value . ' ';
        }
        $spam = HTML::TAG('spam')
                ->setData($data_load[$name])
                ->setAtt(' data-infocontent="' . $infocontent . ' "')
                ->setAtt(' data-tokens="' . $tokens . '"')->builder();
        $p = HTML::TAG("p")
                ->setClass("form-control  form-string")
                ->setData($spam)
                ->builder();
        return $this->div($p);
    }

    public function multiSelectTag(array $input): string
    {
        $name = $input['Field'];
        $Default = $input['Default'];
        $data_load = [];
        foreach ($input['Data_load'] as $row) {
            $ligne = "";
            foreach ($row as $column => $value) {
                $ligne .= $column . '$$$' . $value . ' £££ ';
            }
            $data_load[$row->id] = $ligne;
        }
//////////////////////////////////////////////////////
        $optionTag = [];


        foreach ($Default as $row) {
            $dataOption = "";
            foreach ($row as $column => $value) {
                $dataOption .= $column . '$$$' . $value . ' £££ ';
            }
            $optionTag [] = HTML::TAG('option')
                            ->setValue($row->id)
                            ->setAtt(' data-container="body" '
                                    . 'data-toggle="popover"'
                                    . ' data-placement="top"'
                                    . ' data-content="' . $dataOption . ' " selected ')
                            ->setData($dataOption)->builder();
        }






        $tag = HTML::TAG("select")
                ->setAtt('multiple')
                ->setClass("multiSelectItemwassim form-control  form-childs")
                ->setName($name . '[]')
                ->setData($optionTag)
                ->builder();

        return $this->div($tag, "col-sm-12");
    }

    public function pTage(array $input): string
    {

        $Default = $input['Default'];
        $tag = $inputHTML = HTML::TAG("p")
                ->setClass("form-control  form-string")
                ->setData($Default)
                ->builder();
        return $this->div($tag);
    }

    public function labelTage(array $input): string
    {
        $name = $input['Field'];
        $lable = str_replace("_", " ", str_replace("$", " ", $name));
        $null = $input['Null'];
        if ($null == "NO") {
            $lable .= ' <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> ';
        }
        return HTML::TAG('strong')
                        ->setClass("col-sm-2 col-sm-offset-1 text-right ")
                        ->setData($lable)
                        ->builder();
    }

    private function div($tag, $class = "col-sm-8")
    {
        return HTML::TAG("div")
                        ->setClass($class)
                        ->setData($tag)
                        ->builder();
    }
}
