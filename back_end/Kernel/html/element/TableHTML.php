<?php

/* intent =====> 
  <table class='table table-hover table-bordered'  style='width:100%'> <thead align='center'>
  <tr style='text-align: center'>
  <th  style='text-align: center'>ID</th>
  <th  style='text-align: center'>N</th>
  <th  style='text-align: center'>DATE</th>
  <th  style='text-align: center'>LA SOMME</th>
  <th  style='text-align: center'>RAISON SOCIALE</th>
  <th  style='text-align: center'>BL</th>
  <th  style='text-align: center'>FACTURE</th>
  </tr>
  </thead >
  <tr style='text-align: center'>
  <td style='text-align: center'> 1</td>
  <td style='text-align: center'> AAV333</td>
  <td style='text-align: center'> 2017-10-04</td>
  <td style='text-align: center'> 999</td>
  <td style='text-align: center'> gg</td>
  </tr>


  <tr style='text-align: center'>
  <td style='text-align: center'> 2</td>
  <td style='text-align: center'> avoir2</td>
  <td style='text-align: center'> 2017-10-03</td>
  <td style='text-align: center'> 888</td>
  <td style='text-align: center'> cmgp</td>
  <td style='text-align: center'>
  <table class='table'>
  <tr style='text-align: center'>
  <th  style='text-align: center'>id</th>
  <th  style='text-align: center'>N</th>
  <th  style='text-align: center'>date de livraison</th>
  <th  style='text-align: center'>la somme</th>
  </tr>

  <tr style='text-align: center'>
  <td style='text-align: center'> 1</td>
  <td style='text-align: center'> HHHH</td>
  <td style='text-align: center'> 2017-10-03</td>
  <td style='text-align: center'> 66666</td>
  </tr>


  <tr style='text-align: center'>
  <td style='text-align: center'> 2</td>
  <td style='text-align: center'> JJJ</td>
  <td style='text-align: center'> 2017-10-04</td>
  <td style='text-align: center'> 8888</td>
  </tr>

  </table>
  </td>
  <td style='text-align: center'>
  <table class='table'>
  <tr style='text-align: center'>
  <th  style='text-align: center'>id</th>
  <th  style='text-align: center'>N</th>
  <th  style='text-align: center'>date de emise</th>
  <th  style='text-align: center'>la somme</th>
  </tr>

  <tr style='text-align: center'>
  <td style='text-align: center'> 1</td>
  <td style='text-align: center'> HHH</td>
  <td style='text-align: center'> 2017-10-03</td>
  <td style='text-align: center'> 8888</td>
  </tr>

  </table>
  </td>
  </tr>


  <tr style='text-align: center'>
  <td style='text-align: center'> 3</td>
  <td style='text-align: center'> avoir3</td>
  <td style='text-align: center'> 2017-10-03</td>
  <td style='text-align: center'> 99999</td>
  <td style='text-align: center'> cmgp</td>
  </tr>
  </table>
 */

namespace Kernel\html\element;

use Kernel\html\element\AbstractHTML;
use Kernel\INTENT\Intent;

/**
 * Description of TableHTML
 *
 * @author Wassim Hazime
 */
class TableHTML extends AbstractHTML
{

    
    function __construct($intent)
    {
        parent::__construct($intent);
    }

    public function builder($att)
    {
        $intent=$this->intent;
        $thead = $this->thead($intent);

        $tbody = $this->tbody($intent);
        return "\n<table $att> $thead $tbody </table>";
    }

    protected function thead(Intent $intent): string
    {
        $COLUMNS_master = $intent->getEntitysSchema()->getCOLUMNS_master();
        $COLUMNS_all = $intent->getEntitysSchema()->getCOLUMNS_all();
        $FOREIGN_KEY = $intent->getEntitysSchema()->getFOREIGN_KEY();
        $table_CHILDREN = $intent->getEntitysSchema()->get_table_CHILDREN();

        if (Intent::is_PARENT_MASTER($intent)) {
            $columns = array_merge($COLUMNS_master, $FOREIGN_KEY);
        } elseif (Intent::is_PARENT_ALL($intent)) {
            $columns = array_merge($COLUMNS_all, $FOREIGN_KEY);
        }
        $columns = array_merge($columns, ["controle"=>"controle"]); /////////////
        if (Intent::is_get_CHILDREN($intent)) {
            $columns = array_merge($columns, $table_CHILDREN);
        }
        
        
        
        
        $thead = [];
        foreach ($columns as $column) {
            $thead[] = $this->th(strtoupper(str_replace("_", " ", $column)));
        }
        return "<thead align='center'>" . $this->tr(implode(" \n", $thead)) . " </thead > ";
    }

    protected function tbody(Intent $intent): string
    {
        $table = $intent->getEntitysDataTable();
        $bodys = [];
        foreach ($table as $index => $ROWS) {
            $row = [];
            foreach ($ROWS as $head => $body) {
                $row[] = $this->td($body);
            }
            $row[]=$this->td('<input type="submit" value="effacer  "><input type="submit" value="modifier">');////
            foreach ($intent->getEntitysSchema()->get_table_CHILDREN() as $name_table_child) {
                if ($this->TableCHILD($intent, $index) != []) {
                    $row[] = $this->td($this->TableCHILD($intent, $index)[$name_table_child]);
                }
            }
       
            $bodys[] = $this->tr(implode(" \n", $row));
        }

        return (implode(" \n", $bodys));
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
    protected function TableCHILD(Intent $intent, int $indexROW): array
    {
        if (!Intent::is_get_CHILDREN($intent)) {
            return [];
        }

        $theadCHILD = $this->theadCHILD($intent);
        $tbodyCHILD = $this->tbodyCHILD($intent, $indexROW);

        if (implode("", $tbodyCHILD) == '') {
            return [];
        }






        foreach ($theadCHILD as $nameTABLE => $data) {
            $tableCHILD[$nameTABLE] = "\n<table class='table'>" . $data;
        }

        foreach ($tbodyCHILD as $nameTABLE => $data) {
            $tableCHILD[$nameTABLE] .= $data . "\n</table>\n";
        }

        return $tableCHILD;
    }

    protected function theadCHILD(Intent $intent): array
    {
        $Schema = $intent->getEntitysSchema();
        $theadChild = [];
        foreach ($Schema->get_table_CHILDREN() as $table) {
            $thead = [];
            foreach ($Schema->getCHILDREN()[$table] as $column) {
                $thead[] = $this->th(str_replace("_", " ", $column));
            }



            $theadChild[$table] = $this->tr(implode(" \n", $thead));
        }
        return $theadChild;
    }

    protected function tbodyCHILD(Intent $intent, int $indexROW): array
    {
        $childs = $intent->getEntitysSchema()->get_table_CHILDREN();
        $datajoin = [];
        foreach ($childs as $nameTable) {
            $datajoin[$nameTable] = $intent->getEntitysDataTable()[$indexROW]->getDataJOIN($nameTable);
        }

        foreach ($datajoin as $nameTable => $table) {
            $bodys = [];
            foreach ($table as $ROWS) {
                $row = [];
                foreach ($ROWS as $head => $body) {
                    $row[] = $this->td($body);
                }

                $bodys[] = $this->tr(implode(" \n", $row));
            }

            $datajoin[$nameTable] = (implode(" \n", $bodys));
        }
        return $datajoin;
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////

    protected function tr($content, $att = "style='text-align: center'"): string
    {
        return "\n<tr $att>\n{$content}\n</tr>\n";
    }

    protected function th($content, $att = "style='text-align: center'"): string
    {
        return "<th  $att>{$content}</th>";
    }

    protected function td($content, $att = "style='text-align: center'"): string
    {
        return "<td $att> {$content}</td>";
    }
}
