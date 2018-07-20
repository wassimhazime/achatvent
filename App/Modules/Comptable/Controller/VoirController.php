<?php

namespace App\Modules\Comptable\Controller;

use App\AbstractModules\Controller\AbstractVoirController;
use App\Modules\Comptable\Model\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VoirController extends AbstractVoirController {

    function __construct(ContainerInterface $container, string $page) {
        parent::__construct($container, $page);
        $this->setModel(new Model($container->get("pathModel")));
    }

    public function process(ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface {

        parent::process($request, $handler);

        $flag = $this->chargeModel($this->getPage());
        if (!$flag) {
            return $this->getResponse()->withStatus(404);
        }

        $query = $this->getRequest()->getQueryParams();
        $data = $this->showDataTable($query, "ComptableAjax", "ComptableTraitementShow");
        return $this->render("@ComptableShow/show", $data);
    }

}
