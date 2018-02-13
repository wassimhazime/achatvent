<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\html;

use Kernel\html\ConfigExternal;
use Kernel\html\element\FormHTML;
use Kernel\html\element\TableHTML;
use Kernel\INTENT\Intent;

/**
 * Description of TAG
 *
 * Les décorateurs
 */
class FactoryTAG {

    private $ConfigExternal;

    public function __construct($PathConfigJsone) {


        $this->ConfigExternal = new ConfigExternal($PathConfigJsone);
    }

    //"nette/forms": "^2.4",
    public function tableHTML(Intent $intent) {
        $tablehtml = new TableHTML($intent);
        return $tablehtml->builder("class='table table-hover table-bordered' style='width:100%'");
    }

    public function FormHTML(Intent $intent) {
        $Conevert = ($this->ConfigExternal->getConevert_TypeClomunSQL_to_TypeInputHTML());
        $formhtml = new FormHTML($intent, $Conevert);
        return $formhtml->builder("  ");
    }

}
