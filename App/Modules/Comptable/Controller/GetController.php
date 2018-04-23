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
        $this->model->setStatement($this->page);

        if (isset($query["s"])) {
            $mode = $this->converteMode($query["s"]);
            $intentshow = $this->model->show($mode, true);
            return $this->render("@show/show", ["intent" => $intentshow]);
        } else {
            $intentshow = $this->model->show(Intent::MODE_SELECT_DEFAULT_NULL, true);
            return $this->render("@show/showJson", ["intent" => $intentshow]);
        }
    }
    
    
    
    

    private function converteMode($modeHTTP) {
        switch ($modeHTTP) {
            case "dm":
                $mode = Intent::MODE_SELECT_DEFAULT_MASTER;

                break;
            case "da":

                $mode = Intent::MODE_SELECT_DEFAULT_ALL;
                break;
            case "dd":

                $mode = Intent::MODE_SELECT_DEFAULT_DEFAULT;
                break;
            case "dn":

                $mode = Intent::MODE_SELECT_DEFAULT_NULL;
                break;


            case "mm":
                $mode = Intent::MODE_SELECT_MASTER_MASTER;

                break;
            case "ma":

                $mode = Intent::MODE_SELECT_MASTER_ALL;
                break;
            case "am":

                $mode = Intent::MODE_SELECT_ALL_MASTER;
                break;
            case "aa":
                $mode = Intent::MODE_SELECT_ALL_ALL;

                break;
            case "an":
                $mode = Intent::MODE_SELECT_ALL_NULL;

                break;
            case "mn":

                $mode = Intent::MODE_SELECT_MASTER_NULL;
                break;
            default:
                $mode = Intent::MODE_SELECT_DEFAULT_DEFAULT;
                break;
        }
        return $mode;
    }

}
