<?php

namespace Kernel\html\element;

/**
 * Description of TableHTML
 *
 * @author Wassim Hazime
 */
class TableHTML
{

    public function builder(string $att, array $heade, array $table, array $CHILD = [], array $input = []): string
    {
   
        if (empty($input)) {
            $thead = $this->thead($heade);
            $tbody = $this->tbody($table, $CHILD);
        } else {
            $thead = $this->thead($heade, $input["title"]);
            $tbody = $this->tbody($table, $CHILD, $input["body"]);
        }




        return "\n<table $att> $thead $tbody </table>";
    }

    protected function thead(array $thead_columns, string $input = ""): string
    {
        if ($input!="") {
            $thead_columns = array_merge($thead_columns, [$input]);
        }
        
        $thead = [];
        foreach ($thead_columns as $column) {
            $str = (str_replace("_", " ", $column));
            $thead[] = $this->th(strtoupper(str_replace("$", " ", $str)));
        }
        return "<thead >" . $this->tr(implode(" \n", $thead)) . " </thead > ";
    }

    protected function tbody(array $table, array $CHILD, string $input = ""): string
    {

        $bodys = [];

        foreach ($table as $index => $ROWS) {
            $row = [];
            $ID = "";
            //**********************ROWS***************************///
            foreach ($ROWS as $head => $body) {
                if (strtoupper($head) == "IMAGE") {
                    if ($body == "'image.jpg'") {
                        $body = " ";
                        $id_image = "";
                    } else {
                        $id_image = str_replace("id_image=>", "", $body);
                        $body = '<a class="btn btn-default"  role="button" href="?imageview=' . $id_image . '" >les fichies</a>';
                    }
                } elseif (strtoupper($head) == "ID") {
                    $ID = $body;
                }
                $row[] = $this->td($body);
            }
            //****************************************************///
            //*******************TableCHILD******************************///
          
            if (isset($CHILD["flag_show_CHILDREN"])&&$CHILD["flag_show_CHILDREN"]) {
                $table_CHILDREN = $CHILD["table_CHILDREN"]; /// les noms des tables childe
                $CHILDREN = $CHILD["CHILDREN"]; /// les noms des champs childe
                $datajoins = $CHILD["datajoins"]; // donnes des table child



                $TableCHILD = $this->TableCHILD($table_CHILDREN, $CHILDREN, $datajoins [$index]);

                if ($TableCHILD != []) {
                    foreach ($table_CHILDREN as $name_table_child) {
                        $row[] = $this->td($TableCHILD[$name_table_child]);
                    }
                }
            }
            //********************************************************///
            //*******************input******************************///
            if ($input != "") {
                $row[] = $this->td(str_replace(0, $ID, $input));
            }

            //******************************************************///
            $bodys[] = $this->tr(implode(" \n", $row));
        }

        return (implode(" \n", $bodys));
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
    protected function TableCHILD($table_CHILDREN, $CHILDREN, $datajoin): array
    {
        $theadCHILD = $this->theadCHILD($table_CHILDREN, $CHILDREN);
        $tbodyCHILD = $this->tbodyCHILD($datajoin);



        if (implode("", $theadCHILD) == '') {
            return [];
        }

        $tableCHILD = [];
        foreach ($theadCHILD as $nameTABLE => $data) {
            $tableCHILD[$nameTABLE] = "\n<table class='table'>" . $data;
        }

        foreach ($tbodyCHILD as $nameTABLE => $data) {
            if ($data != " vide") {
                $tableCHILD[$nameTABLE] .= $data . "\n</table>\n";
            } else {
                $tableCHILD[$nameTABLE] .= "\n</table>\n";
            }
        }

        return $tableCHILD;
    }

    protected function theadCHILD($table_CHILDREN, $CHILDREN): array
    {

        $theadChild = [];
        foreach ($table_CHILDREN as $table) {
            $thead = [];
            foreach ($CHILDREN[$table] as $column) {
                $thead[] = $this->th(str_replace("_", " ", $column));
            }



            $theadChild[$table] = $this->tr(implode(" \n", $thead));
        }
        return $theadChild;
    }

    protected function tbodyCHILD($datajoin): array
    {



        foreach ($datajoin as $nameTable => $table) {
            $bodys = [];
            foreach ($table as $ROWS) {
                $row = [];
                foreach ($ROWS as $head => $body) {
                    $row[] = $this->td($body);
                }

                $bodys[] = $this->tr(implode(" \n", $row));
            }
            if (empty($bodys)) {
                $bodys[] = " vide";
            }

            $datajoin[$nameTable] = (implode(" \n", $bodys));
        }
        return $datajoin;
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////

    protected function tr($content, $att = ""): string
    {
        return "\n<tr $att>\n{$content}\n</tr>\n";
    }

    protected function th($content, $att = ""): string
    {
        return "<th  $att>{$content}</th>";
    }

    protected function td($content, $att = ""): string
    {
        return "<td $att> {$content}</td>";
    }
}
