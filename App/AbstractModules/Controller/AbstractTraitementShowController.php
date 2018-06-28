<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\AbstractModules\Controller;

/**
 * Description of PostController
 *
 * @author wassime
 */
use GuzzleHttp\Psr7\Response;
use Kernel\INTENT\Intent;
use function preg_match;

abstract class AbstractTraitementShowController extends AbstractController {

    public function supprimer($id,string $view) {

        $conditon = ['id' => $id];

        $url_id_file = $this->getModel()->get_idfile($conditon);

        preg_match('!(.+)'
                . 'data-regex="/(.+)/"'
                . '(.+)!i', $url_id_file, $matches);

        $etat = $this->getModel()->delete($conditon);
        if ($etat == -1) {
            $r = new Response(404);
            $r->getBody()->write("accès refusé  de supprimer ID  $id");
            return $r;
        } else {
            $this->getResponse()->getBody()->write("$view  $id");

            if (!empty($matches) && isset($matches[2])) {

                $this->getFile_Upload()->delete($matches[2]);
            }
        }
        return $this->getResponse();
    }

    public function modifier($id,string $view) {
        $page = $this->getPage();
        $conditon = ["$page.id" => $id];
        $intentform = $this->getModel()->formDefault($conditon);
        return $this->render($view, ["intent" => $intentform]);
    }

    public function ajouter_select(string $view) {
        $intentformselect = $this->getModel()->formSelect();
        if (!empty($intentformselect->getMETA_data())) {
            return $this->render($view, ["intent" => $intentformselect]);
        } else {
           return null;  
        }
        
    }

    public function ajouter($getInfo,string $view) {
        unset($getInfo["ajouter"]);
        $intentform = $this->getModel()->form($getInfo);
        return $this->render($view, ["intent" => $intentform]);
    }

    public function show($id,string $view) {
        $intent = $this->getModel()->show_id($id);
        return $this->render($view, ["intent" => $intent]);
    }

    public function message($id,string $view) {

        $mode = Intent::MODE_SELECT_DEFAULT_NULL;

        $intentshow = $this->getModel()->show_in($mode, $id);

        return $this->render($view, ["intent" => $intentshow]);
    }

}
