<?php

namespace App\Modules\Achats\Controller;

use App\AbstractModules\Controller\AbstractVoirController;
use App\Modules\Achats\Model\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VoirController extends AbstractVoirController {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        $this->setModel(new Model($this->getContainer()->get("pathModel")));

        parent::process($request, $handler);
        return $this->showDataTable("@AchatsShow/show", "AchatsAjax", "AchatsTraitementShow");
    }

}
