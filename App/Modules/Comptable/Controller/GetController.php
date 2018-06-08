<?php

namespace App\Modules\Comptable\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Kernel\INTENT\Intent;

class GetController extends AbstractController {

    public function exec(): ResponseInterface {
        $query = $this->request->getQueryParams();

        return $this->show($query);
    }

    public function show($query) {
        $this->getModel()->setStatement($this->page);

        if ($this->getModel()->is_null()) {
            die("erre");
        }
        if (isset($query["imageview"])) {
            $id_image = $query["imageview"];
            return $this->File_Upload->get($id_image);
        }

        
        $optiondatatable = $this->getOptionDataTable($query);
        $modeshow = $this->getModeShow($query);
        $modeintent = $modeshow["modeIntent"];
        $modetype = $modeshow["type"];
        $intentshow = $this->getModel()->show($modeintent, true);
        $data=[
            "intent" => $intentshow,
            "optiondatatable"=>$optiondatatable
                ];

       


        if ($modetype=="HTML") {
          return $this->render("@show/showHtml", $data);
        } elseif(($modetype=="json")) {
          return $this->render("@show/showJson", $data);
        }
    }

    private function getModeShow(array $modeHTTP): array {
        $parent = "MASTER";
        $child = "EMPTY";
        $type = "json";
        if (isset($modeHTTP["pere"])) {
            $parent = $this->parseMode($modeHTTP["pere"], "MASTER");
        }
        if (isset($modeHTTP["fils"])) {
            $child = $this->parseMode($modeHTTP["fils"], "EMPTY");
            if ($child != "EMPTY") {
                $type = "HTML";
            }
        }


        return ["type" => $type, "modeIntent" => [$parent, $child]];
    }

    private function parseMode(string $modefr, $default): string {
        switch ($modefr) {
            case "rien":
                $mode = "EMPTY";

                break;
            case "resume":
                $mode = "MASTER";
                break;
            case "defaut":
                $mode = "DEFAULT";
                break;
            case "tous":
                $mode = "ALL";
                break;

            default:
                $mode = $default;
                break;
        }
        return $mode;
    }

    private function getOptionDataTable(array $modeHTTP): string {
        $option = [];
        if (isset($modeHTTP["copier"])) {
            $option[] = "copyHtml5";
        }
        if (isset($modeHTTP["pdf"])) {
            $option[] = "pdfHtml5";
        }
        if (isset($modeHTTP["excelHtml5"])) {
            $option[] = "excel";
        }
        if (isset($modeHTTP["impression"])) {
            $option[] = "print";
        }
        return implode(" ", $option);
    }

}
