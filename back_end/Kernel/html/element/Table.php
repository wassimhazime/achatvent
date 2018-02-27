<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 */

namespace Kernel\html\element;

/**
 * Description of Table
 *
 * @author wassime
 */
class Table {

    function __construct() {
        
    }

    public function builder(array $thead = [], array $tbody = []): string {


        return $this->table($this->thead($thead) . " " . $this->tbody($tbody));
    }

    protected function table(string $content, string $att = "style='text-align: center'"): string {
        return "\n<table $att>\n{$content}\n</table>\n";
    }

    protected function thead(array $thead_columns, string $att = 'align="center"'): string {

        $thead = [];
        foreach ($thead_columns as $column) {
           
            $thead[] = $this->th(strtoupper(str_replace("_", " ", $column)));
        }

        return " <thead $att >" . $this->tr(implode("    \n", $thead)) . " </thead > \n\n";
    }

    protected function tbody(array $tbody_columns, string $att = 'align="center"'): string {
        $tbody = [];

        foreach ($tbody_columns as $row) {
            $ROWS = [];
            foreach ($row as $cell) {
                if (is_string($cell)) {
                    $td = $cell;
                } elseif (is_array($cell)) {
                    $td = (new self())->builder($cell[0], $cell[1]);
                } else {
                    $td="";
                }
                $ROWS[] = $this->td($td);
            }
            $tbody[] = $this->tr(implode(" \n", $ROWS));
        }
        return "<tbody $att >" . (implode(" \n", $tbody) . " </tbody > ");
    }

    protected function tr(string $content, string $att = "style='text-align: center'"): string {
        return "\n  <tr $att>\n{$content}\n  </tr>\n";
    }

    protected function th(string $content, string $att = "style='text-align: center'"): string {
        return "    <th  $att>{$content}</th>";
    }

    protected function td(string $content, string$att = "style='text-align: center'"): string {
        return "    <td $att> {$content}</td>";
    }

}
