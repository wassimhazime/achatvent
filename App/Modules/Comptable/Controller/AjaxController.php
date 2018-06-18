<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Modules\Comptable\Controller;

use Psr\Http\Message\ResponseInterface;

/**
 * Description of AjaxController
 *
 * @author wassime
 */
class AjaxController extends AbstractController {

    //put your code here
    public function exec(): ResponseInterface {
        return $this->ajax_js();
        }

}
