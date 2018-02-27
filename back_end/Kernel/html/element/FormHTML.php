<?php

namespace Kernel\html\element;

use Kernel\html\element\AbstractHTML;
use Kernel\INTENT\Intent;

class FormHTML extends AbstractHTML {

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
            $this->input[] = ["Field" => $name_CHILDREN,
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

    public function builder($att) {
        $INPUT = [];
        foreach ($this->input as $input) {
            $labelHTML = $this->labelHTML($input);
            switch ($input['Type']) {
                case "textarea":
                    $inputHTML = $this->textareaHTML($input);
                    break;
                case "select":
                    $inputHTML = $this->selectHTML($input);
                    break;
                case "multiSelect":
                    $inputHTML = $this->multiSelectHTML($input);
                    break;
                default:
                    $inputHTML = $this->inputHTML($input);
                    break;
            }
            $INPUT[] = $this->divHTML([$labelHTML, $inputHTML]);
        }

        $builder = implode("\n", $INPUT);

        return $builder;
    }

}
