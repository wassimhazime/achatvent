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
        ];
    }

    public function input_tableHtml(array $context, string $nameroute): array {
       
        $page = $context["page"];
        $router = $context["router"];

        $supprimer = $router->generateUri($nameroute, ["controle" => $page,
            "action" => "supprimer",
            "id" => 0]);
        $modifier = $router->generateUri($nameroute, ["controle" => $page,
            "action" => "modifier",
            "id" => 0]);
        $voir = $router->generateUri($nameroute, ["controle" => $page,
            "action" => "voir",
            "id" => 0]);

        $input = ["title" => 'LES ACTIONS',
            "body" => '<spam style="display: inline-block;    width: max-content;">'
            . '<a class="btn btn-danger  "   href="' . $supprimer . '" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>'
            . '<a class="btn btn-success"    href="' . $modifier . '" ><span class="glyphicon glyphicon-wrench" aria-hidden="true"></span></a>'
            . '<a class="btn btn-primary"    href="' . $voir . '" ><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>'
            . '</spam>'
        ];
        return $input;
    }

}
