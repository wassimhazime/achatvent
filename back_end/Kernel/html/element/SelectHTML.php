<?php

namespace Kernel\html\element;

use Kernel\html\HTML;

class SelectHTML {

    public function selectTage(array $input): string {

        $optionTag = [];
        foreach ($input['DataFOREIGN_KEY'] as $op) {
            $name = ($input['Field']);

            $optionTag [] = HTML::TAG('option')
                    ->setValue($op->id)
                    ->setData($op->$name)
                    ->builder();
        }

        return HTML::TAG("select")
                        ->setClass("form-control")
                        ->setData($optionTag)
                        ->setName($input['Field'])
                        ->builder();
    }

    public function multiSelectTag(array $input): string {
        $optionTag = [];
        foreach ($input['DataCHILDRENS'] as $row) {
            $dataOption = "";
            foreach ($row as $column => $value) {
                $dataOption .= $column . '$$$' . $value . ' £££ ';
            }
            $optionTag [] = HTML::TAG('option')
                    ->setValue($row->id)
                    ->setAtt(' data-container="body" '
                            . 'data-toggle="popover"'
                            . ' data-placement="top"'
                            . ' data-content="' . $dataOption . ' "')
                    ->setData($dataOption)->builder();
        }

        return HTML::TAG("select")
                        ->setAtt('multiple')
                        ->setClass("multiSelectItemwassim form-control")
                        ->setName($input['Field'] . '[]')
                        ->setData($optionTag)->builder();
    }



}
