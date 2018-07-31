<?php

namespace App\Modules\CRM\Controller;

use App\AbstractModules\Controller\AbstractVoirController;
use App\Modules\CRM\Model\Model;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VoirController extends AbstractVoirController {

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        $this->setModel(new Model($this->getContainer()->get("pathModel")));

        parent::process($request, $handler);

        return $this->showDataTable("@CRMShow/show","CRMAjax", "CRMTraitementShow");
      
    }

}
