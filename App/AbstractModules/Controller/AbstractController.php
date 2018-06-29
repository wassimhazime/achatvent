<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author wassime
 */

namespace App\AbstractModules\Controller;

use Kernel\Controller\Controller;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractController extends Controller {

    function __construct(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container, string $page) {
        parent::__construct($request, $response, $container, $page);
    }

    protected function getModeShow(array $modeHTTP): array {
        $parent = "DEFAULT";
        $child = "EMPTY";

        $type = "json";
        if (isset($modeHTTP["pere"])) {
            $parent = $this->parseMode($modeHTTP["pere"], $parent);
        }
        if (isset($modeHTTP["fils"])) {
            $child = $this->parseMode($modeHTTP["fils"], $child);
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

    protected function chargeModel($table) {
        $flag = $this->getModel()->setStatement($table);
        return $flag;
    }

}
