<?php

namespace App\Modules\CRM\Controller;

use App\AbstractModules\Controller\AbstractVoirController;
use App\Modules\CRM\Model\Model;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VoirController extends AbstractVoirController
{

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->setModel(new Model($this->getContainer()->get("pathModel")));

        parent::process($request, $handler);
        
        if ($this->is_Erreur()) {
            return $this->getResponse()->withStatus(404);
        }
        

        $query = $this->getRequest()->getQueryParams();
        $data = $this->showDataTable($query, "CRMAjax", "CRMTraitementShow");
        return $this->render("@CRMShow/show", $data);
    }
}
