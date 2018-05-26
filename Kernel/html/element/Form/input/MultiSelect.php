<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html\element\Form\input;

use Kernel\html\Components\Modals;
use Kernel\html\element\Form\input\Abstract_Input;
use Kernel\html\HTML;

/**
 * Description of MultiSelect
 *
 * @author wassime
 */
class MultiSelect extends Abstract_Input {

    //put your code here

    private function data_load() {
        $data_load = [];
        foreach ($this->input['Data_load'] as $row) {
            $ligne = "";
            $att_data_html = "";
            foreach ($row as $column => $value) {
                $ligne .= $column . '$$$' . $value . ' £££ ';
                $att_data_html .= " data-content_" . $column . '="' . $value . '" ';
            }
        
            $data_load[$row->id] = ["value" => $ligne, "att" => $att_data_html];
        }
        return $data_load;
    }

    private function chargeOption($data_load, $Default) {
        $optionTag = [];
        foreach ($data_load as $id => $data) {
            $optionTag [] = HTML::TAG('option')
                            ->setValue($id)
                            ->setAtt($data["att"])
                            ->setData($data["value"])->builder();
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
        return $optionTag;
    }

    public function builder() {
        $name = $this->name;
        $id_html = $this->id_html;
        $Default = $this->Default;
        $data_load = $this->data_load();

//////////////////////////////////////////////////////
        $optionTag = $this->chargeOption($data_load, $Default);
        $Multiselecttag = HTML::TAG("select")
                ->setAtt('multiple')
                ->setClass(" multiSelectItemwassim form-control form-childs")
                ->setId($id_html)
                ->setName($name . '[]')
                ->setData($optionTag)
                ->builder();

        return $this->div($Multiselecttag,count($optionTag));
    }

    protected function div($Multiselecttag,$badge="") {
        
        $modal = new Modals($this->lable, $Multiselecttag,"",$badge);

        return $modal->builder();
    }

}
