<?php

namespace App\Modules\Transactions\Controller;

use App\AbstractModules\Controller\AbstractVoirController;
use App\Modules\Transactions\Model\Model;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class VoirController extends AbstractVoirController
{



    public function process(ServerRequestInterface $request, \Psr\Http\Server\RequestHandlerInterface $handler): ResponseInterface
    {
        $this->setModel(new Model($this->getContainer()->get("pathModel")));

        $response = parent::process($request, $handler);
        if ($response->getStatusCode() === 404) {
            return $response;
        }
        $query = $this->getRequest()->getQueryParams();
        $data = $this->showDataTable($query, "TransactionAjax", "TransactionTraitementShow");
        return $this->render("@TransactionsShow/show", $data);
    }
}
