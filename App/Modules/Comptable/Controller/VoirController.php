<?php

namespace App\Modules\Comptable\Controller;

use App\AbstractModules\Controller\AbstractVoirController;
use App\Modules\Comptable\Model\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VoirController extends AbstractVoirController {

    function __construct(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container, string $page) {
        parent::__construct($request, $response, $container, $page);
        $this->setModel(new Model($container->get("pathModel")));
    }

    public function exec(): ResponseInterface {
        $this->getModel()->setStatement($this->getPage());

        if ($this->getModel()->is_null()) {
            return $this->render("404", ["_page" => "404"]);
        }

        $query = $this->getRequest()->getQueryParams();
        $data = $this->showDataTable($query,"ComptableAjax");
        return $this->render("@ComptableShow/show", $data);
    }

}
