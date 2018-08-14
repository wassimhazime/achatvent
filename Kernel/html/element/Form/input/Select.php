<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of select
 *
 * @author wassime
 */

namespace Kernel\html\element\Form\input;

use Kernel\html\element\Form\input\Abstract_Input;
use Kernel\html\HTML;
use Kernel\Tools\Tools;

class Select extends Abstract_Input {

    //put your code here
    public function builder() {
        $name = $this->name;
        $id_html = $this->id_html;
        $Default = $this->Default;
        $optionTag = [];
        $data_load = [];
        foreach ($this->input['Data_load'] as $row) {
            $data_load[$row["id"]] = Tools::entitys_TO_array($row);
        }

///////////////////////////////////////////////////////////////////

        foreach ($data_load as $key => $data) {
            $infocontent = "";
            $tokens = "";
            foreach ($data as $column => $value) {
                $infocontent .= $column . '$$$' . $value . ' £££ ';
                $tokens .= $value . ' ';
            }



            $rowTag = HTML::TAG('option')
                    ->setValue($key)
                    ->setData($data[$this->input['Field']])
                    ->setAtt(' data-infocontent="' . $infocontent . ' "')
                    ->setAtt(' data-tokens="' . $tokens . '"')

            ;

            if ($Default == $data[$this->input['Field']]) {
                $rowTag->setAtt("selected");
            }
            $optionTag [] = $rowTag->builder();
        }

        if (count($data_load) === 1) {
            $tag = HTML::TAG("select")
                    ->setClass(" form-control form-string input-sm")
                    ->setData($optionTag)
                    ->setId($id_html)
                    ->setName($name . $this->child)
                    ->setAtt(" readonly  ");

            if ($this->child === "[]") {
                $tag = $tag->setClass(" hidden ");
                $this->lable = "";
            }
            $tag = $tag->builder();
            return $this->div($tag);
        } else {
            $tag = HTML::TAG("select")
                    ->setClass(" selectpicker form-control input-sm")
                    ->setId($id_html)
                    ->setAtt(' data-live-search="true"  data-size="5" data-container="body" ')
                    ->setAtt('  data-set_null="' . $this->null . '" ')
                    ->setData($optionTag)
                    ->setName($name . $this->child)
                    ->builder();
            return $this->div($tag, "col-sm-6");
        }
    }

}
