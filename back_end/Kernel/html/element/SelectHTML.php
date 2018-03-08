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
    return HTML::TAG("select")
                 ->setAtt('multiple')
                 ->setClass("multiSelectItemwassim form-control")
                 ->setName($input['Field'] . '[]')
                 ->setData($this->chargeListHtml($input['DataCHILDRENS']) )
                 ->builder();
       
    }

    private function chargeListHtml($DataCHILDRENS, $param = '') {
        $TAGoption = "";
        foreach ($DataCHILDRENS as $row) {
            if (!isset($row->id)) {
                return "<option></option>";
            }
            $dataOption = '';
            foreach ($row as $column => $value) {
                $dataOption .= $column . '$$$' . $value . ' £££ ';
            }
            $popover = 'data-container="body" data-toggle="popover" data-placement="top" data-content="' . $dataOption . ' "';
            $TAGoption .= "<option $param $popover " . "  value ={$row->id}> $dataOption </option> ";
            // $TAGoption .= "<option $param $popover " . "  value ={$row->id}> {$row->id} </option> ";
        }
        return $TAGoption;
    }

}
