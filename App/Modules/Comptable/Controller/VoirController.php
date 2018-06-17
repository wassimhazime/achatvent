<?php

namespace App\Modules\Comptable\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Kernel\INTENT\Intent;

class VoirController extends AbstractController {

    public function exec(): ResponseInterface {
        $this->getModel()->setStatement($this->getPage());
        if ($this->getModel()->is_null()) {
            return $this->render("@show/show");
        }

        $query = $this->getRequest()->getQueryParams();
       
        $data = $this->showDataTable($query);
        return $this->render("@show/show", $data);
    }

    private function showDataTable($query) {


        $modeshow = $this->getModeShow($query);
        $modeintent = $modeshow["modeIntent"];
        
        $data = [
            "Html_or_Json" => $modeshow["type"],
            "btnDataTable" => $this->btn_DataTable($query)["btn"],
            "jsCharges" => $this->btn_DataTable($query)["jsCharges"],
            "modeintentpere"=>$modeintent[0],
            "modeintentenfant"=>$modeintent[1]
        ];

        
        if ($modeshow["type"] === "HTML") {
            $data["intent"] = $this->getModel()->show($modeintent, true);
        } elseif ($modeshow["type"] === "json") {
            $url= $this->getRouter()
               ->generateUri("ajaxcomptable",
                              ["controle" => $this->getPage()]);
            
            $get="?".$this->getRequest()->getUri()->getQuery();
            $data["ajax"] =$url.$get;
      }

        return $data;
    }

    private function btn_DataTable(array $modeHTTP): array {

        $param = "pageLength colvis";
        $jsCharge = [];
        if (isset($modeHTTP["copier"]) && $modeHTTP["copier"] == "on") {
            $param .= " copyHtml5";
            $jsCharge["copier"] = true;
        }
        if (isset($modeHTTP["pdf"]) && $modeHTTP["pdf"] == "on") {
            $param .= " pdfHtml5";
            $jsCharge["pdf"] = true;
        }
        if (isset($modeHTTP["excel"]) && $modeHTTP["excel"] == "on") {
            $param .= " excelHtml5";
            $jsCharge["excel"] = true;
        }
        if (isset($modeHTTP["impression"]) && $modeHTTP["impression"] == "on") {
            $param .= " print";
            $jsCharge["print"] = true;
        }
        $param .= " control";

        return ["btn" => $param, "jsCharges" => $jsCharge];
    }

}
