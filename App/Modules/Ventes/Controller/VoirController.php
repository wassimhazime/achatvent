<?php

namespace App\Modules\Ventes\Controller;

use App\AbstractModules\Controller\AbstractVoirController;
use App\Modules\Ventes\Model\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VoirController extends AbstractVoirController
{


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->setModel(new Model($this->getContainer()->get("pathModel")));

        $response = parent::process($request, $handler);
        if ($response->getStatusCode() === 404) {
            return $response;
        }

        $query = $this->getRequest()->getQueryParams();
        $data = $this->showDataTable($query, "VentesAjax", "VentesTraitementShow");
        return $this->render("@VentesShow/show", $data);
    }
}
