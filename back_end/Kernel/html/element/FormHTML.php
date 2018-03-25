<?php

namespace Kernel\html\element;

use Kernel\html\HTML;

class FormHTML
{

    protected $input = [];
    protected $Conevert_TypeClomunSQL_to_TypeInputHTML;

    function __construct($COLUMNS_META_object, array $Conevert_TypeClomunSQL_to_TypeInputHTML, $entitysDataTable, $DefaultData = [])
    {
        $COLUMNS_META = json_decode(json_encode($COLUMNS_META_object), true);
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
                "Null" => "NO",
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
                case "textarea":
                    $inputHTML = $this->textareaTage($input);
                    break;
                case "select":
                    $inputHTML = $this->selectTage($input);
                    break;
                case "multiSelect":
                    $inputHTML = $this->multiSelectTag($input);
                    break;
                default:
                    $inputHTML = $this->inputTage($input);
                    break;
            }

            $labelHTML = $this->labelTage($input);
            $INPUT[] = HTML::TAG("div")
                    ->setClass("form-group")
                    ->setData([$labelHTML, $inputHTML])
                    ->builder();
        }

        $builder = implode("\n", $INPUT);

        return $builder;
    }

    public function selectTage(array $input): string
    {
        $name = $input['Field'];
        $Default = $input['Default'];
        $optionTag = [];
        $data_load = [];
        foreach ($input['Data_load'] as $row) {
            $data_load[$row->id] = $row->$name;
        }

///////////////////////////////////////////////////////////////////
        foreach ($data_load as $key => $data) {
            $rowTag = HTML::TAG('option')
                    ->setValue($key)
                    ->setData($data);
            if ($Default == $data) {
                $rowTag->setAtt("selected");
            }
            $optionTag [] = $rowTag->builder();
        }

        return HTML::TAG("select")
                        ->setClass("form-control form-string")
                        ->setData($optionTag)
                        ->setName($name)
                        ->builder();
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
        foreach ($data_load as $key => $data) {
            $optionTag [] = HTML::TAG('option')
                            ->setValue($key)
                            ->setAtt(' data-container="body" '
                                    . 'data-toggle="popover"'
                                    . ' data-placement="top"'
                                    . ' data-content="' . $data . ' "')
                            ->setData($data)->builder();
        }
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






        return HTML::TAG("select")
                        ->setAtt('multiple')
                        ->setClass("multiSelectItemwassim form-control form-childs")
                        ->setName($name . '[]')
                        ->setData($optionTag)
                        ->builder();
    }

    public function labelTage(array $input): string
    {
        $name = $input['Field'];
        return HTML::TAG('label')
                        ->setClass("control-label")
                        ->setData(str_replace("_", " ", $name))
                        ->setFor($name)
                        ->builder();
    }

    public function inputTage(array $input): string
    {
        $name = $input['Field'];
        $Default = $input['Default'];
        $type = $input['Type'];

        $tag = HTML::TAG('input')
                ->setClass("form-control")
                ->setType($type)
                ->setName($name)
                ->setPlaceholder(str_replace("_", " ", $name))
                ->setValue($Default);
        if ($input['Type'] == "file") {
            
                    $tag->setClass("form-file form-control")
                    ->setAtt('multiple accept=" .jpg, .jpeg, .png"')
                    ->setName($name . "[]");
        } else {
               $tag->setClass("form-string form-control") ;
        }
        return $tag->builder();
    }

    public function textareaTage(array $input): string
    {
        $name = $input['Field'];
        $Default = $input['Default'];
        return $inputHTML = HTML::TAG("textarea")
                ->setClass("form-control form-string")
                ->setName($name)
                ->setPlaceholder(str_replace("_", " ", $name))
                ->setValue($Default)
                ->setData($Default)
                ->setTag("textarea")
                ->builder();
    }
}
