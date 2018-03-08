<?php

namespace Kernel\html\element;

use Kernel\html\HTML;

class FormHTML {

    protected $input = [];
    protected $Conevert_TypeClomunSQL_to_TypeInputHTML;

    function __construct($COLUMNS_META_object, $entitysDataTable, array $Conevert_TypeClomunSQL_to_TypeInputHTML) {
        $COLUMNS_META = json_decode(json_encode($COLUMNS_META_object), true);
        $this->Conevert_TypeClomunSQL_to_TypeInputHTML = $Conevert_TypeClomunSQL_to_TypeInputHTML;
//// change taype sql to type html

        foreach ($COLUMNS_META as $COLUMN_META) {
            $COLUMN_META['Type'] = ($this->conevert_TypeClomunSQL_to_TypeInputHTML($COLUMN_META['Type']));
            $this->input[$COLUMN_META["Field"]] = $COLUMN_META;

            if ($COLUMN_META["Key"] == "MUL") {
                $DataFOREIGN_KEY = $entitysDataTable["FOREIGN_KEYs"][$COLUMN_META["Field"]];
                $this->input[$COLUMN_META["Field"]]["DataFOREIGN_KEY"] = $DataFOREIGN_KEY;
            }
        }



        foreach ($entitysDataTable["CHILDRENs"] as $name_CHILDREN => $data) {
            $this->input[] = [
                "Field" => $name_CHILDREN,
                "Type" => "multiSelect",
                "Null" => "NO",
                "Key" => "",
                "Default" => "",
                "Extra" => "",
                "DataCHILDRENS" => $data];
        }
    }

    private function conevert_TypeClomunSQL_to_TypeInputHTML(string $Type): string {

        $Conevert = $this->Conevert_TypeClomunSQL_to_TypeInputHTML;

        if (isset($Conevert[$Type])) {
            return $Conevert[$Type];
        } else {
            return "text";
        }
    }

    public function builder($att, $DefaultData = []) {




        $INPUT = [];

        foreach ($this->input as $input) {
            if (isset($DefaultData[$input['Field']])) {
                $input['Default'] = $DefaultData[$input['Field']];
            }
            $labelHTML = HTML::TAG('label')
                    ->setClass("control-label")
                    ->setData(str_replace("_", " ", $input['Field']))
                    ->setFor($input['Field'])
                    ->builder();
            switch ($input['Type']) {
                case "textarea":
                    $inputHTML = HTML::TAG("textarea")
                            ->setClass("form-control")
                            ->setName($input['Field'])
                            ->setPlaceholder(str_replace("_", " ", $input['Field']))
                            ->setValue($input['Default'])
                            ->setData($input['Default'])
                            ->setTag("textarea")
                            ->builder();
                    break;
                case "select":
                    $select=new SelectHTML();
                    $inputHTML = $select->selectTage($input);
                    break;
                case "multiSelect":
                    $select=new SelectHTML();
                    $inputHTML = $select->multiSelectTag($input);
                    break;
                default:

                    $tag = HTML::TAG('input')
                            ->setClass("form-control")
                            ->setType($input['Type'])
                            ->setName($input['Field'])
                            ->setPlaceholder(str_replace("_", " ", $input['Field']))
                            ->setValue($input['Default']);
                    if ($input['Type'] == "file") {
                        $tag->setAtt('multiple accept=" .jpg, .jpeg, .png"')
                        ->setName($input['Field']."[]");
                    }
                    $inputHTML = $tag->builder();

                    break;
            }
            $INPUT[] = HTML::TAG("div")
                    ->setClass("form-group")
                    ->setData([$labelHTML, $inputHTML])
                    ->builder();
        }

        $builder = implode("\n", $INPUT);

        return $builder;
    }

}
