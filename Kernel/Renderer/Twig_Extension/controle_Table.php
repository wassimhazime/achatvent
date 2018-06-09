<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\Renderer\Twig_Extension;

class controle_Table extends \Twig_Extension {

    public function getFunctions() {
        return [
            new \Twig_SimpleFunction("input_tableHtml", [$this, "input_tableHtml"], ['is_safe' => ['html'], 'needs_context' => true]),
            new \Twig_SimpleFunction("input_tableJson", [$this, "input_tableJson"], ['is_safe' => ['html'], 'needs_context' => true]),
        ];
    }

    public function input_tableJson(array $context, string $nameroute): string {
        $url = $this->getUrl($context, $nameroute);
        $message = "urlmessage|" . $url["message"];
        $supprimer = "urlsupprimer|" . $url["supprimer"];
        $modifier = "urlmodifier|" . $url["modifier"];
        $voir = "urlvoir|" . $url["voir"];

        return $message . "~" . $supprimer . "~" . $modifier . "~" . $voir;
    }

    public function input_tableHtml(array $context, string $nameroute): array {

        $url = $this->getUrl($context, $nameroute);
        $message = $url["message"];
        $supprimer = $url["supprimer"];
        $modifier = $url["modifier"];
        $voir = $url["voir"];


        $input = ["title" => 'LES ACTIONS',
            "body" => '<spam style="display: inline-block;    width: max-content;">'
            . '<button class="btn btn-danger   supprimer" data-urlmessage="' . $message . '"   data-urlsup="' . $supprimer . '" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>'
            . '<a class="btn btn-success  modifier"    href="' . $modifier . '" ><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>'
            . '<a class="btn btn-primary  voir"    href="' . $voir . '" ><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>'
            . '</spam>'
        ];
        return $input;
    }

    private function getUrl(array $context, string $nameroute) {

        $page = $context["_page"]; // class controller main
        $router = $context["router"]; // class App
        $url = [];

        $url["supprimer"] = $router->generateUri($nameroute, ["controle" => $page,
            "action" => "supprimer",
            "id" => 0]);
        $url["modifier"] = $router->generateUri($nameroute, ["controle" => $page,
            "action" => "modifier",
            "id" => 0]);
        $url["voir"] = $router->generateUri($nameroute, ["controle" => $page,
            "action" => "voir",
            "id" => 0]);
        $url["message"] = $router->generateUri($nameroute, ["controle" => $page,
            "action" => "message",
            "id" => 0]);

        return $url;
    }

}
