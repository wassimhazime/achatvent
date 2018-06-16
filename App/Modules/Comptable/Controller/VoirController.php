<?php

namespace App\Modules\Comptable\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Kernel\INTENT\Intent;

class VoirController extends AbstractController {

    public function exec(): ResponseInterface {
        $query = $this->getRequest()->getQueryParams();

        return $this->show($query);
    }

    private function show($query) {
        $this->getModel()->setStatement($this->getPage());

        if ($this->getModel()->is_null()) {
            die("erre");
        }
        if (isset($query["imageview"])) {
            $id_image = $query["imageview"];
            return $this->getFile_Upload()->get($id_image);
        }


        $btndatatable = $this->btn_DataTable($query);
        $js = $this->js_charge($query);
        $modeshow = $this->getModeShow($query);
        $modeintent = $modeshow["modeIntent"];
        $modetype = $modeshow["type"];
        
        $intentshow = $this->getModel()->show($modeintent, true);
        $data = [
            "modetype" => $modetype,
            "intent" => $intentshow,
            "btndatatable" => $btndatatable,
            "js" => $js
        ];
        return $this->render("@show/show", $data);

        
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

    private function btn_DataTable(array $modeHTTP): string {
        $option = ['pageLength', "colvis"];
        if (isset($modeHTTP["copier"]) && $modeHTTP["copier"] == "on") {
            $option[] = "copyHtml5";
        }
        if (isset($modeHTTP["pdf"]) && $modeHTTP["pdf"] == "on") {
            $option[] = "pdfHtml5";
        }
        if (isset($modeHTTP["excel"]) && $modeHTTP["excel"] == "on") {
            $option[] = "excelHtml5";
        }
        if (isset($modeHTTP["impression"]) && $modeHTTP["impression"] == "on") {
            $option[] = "print";
        }
        $option[] = "control";
        return implode(" ", $option);
    }

    private function js_charge(array $modeHTTP) {
        $option = [];
        if (isset($modeHTTP["copier"]) && $modeHTTP["copier"] == "on") {
            $option["copier"] = true;
        }
        if (isset($modeHTTP["pdf"]) && $modeHTTP["pdf"] == "on") {
            $option["pdf"] = true;
        }
        if (isset($modeHTTP["excel"]) && $modeHTTP["excel"] == "on") {
            $option["excel"] = true;
        }
        if (isset($modeHTTP["impression"]) && $modeHTTP["impression"] == "on") {
            $option["print"] = true;
        }

        return $option;
    }

}
