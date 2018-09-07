<?php

use App\Middleware\Authentification;
use App\Modules\Achats\AchatsModule;
use App\Modules\CRM\CRMModule;
use App\Modules\Statistique\StatistiqueModule;
use App\Modules\Transactions\TransactionsModule;
use App\Modules\Ventes\VentesModule;
use Kernel\AWA_Interface\RendererInterface;
$container = $app->getContainer();

$app->addModule(StatistiqueModule::class);
$app->addModule(CRMModule::class);
$app->addModule(AchatsModule::class);
$app->addModule(VentesModule::class);


$app->addModule(TransactionsModule::class, [
  //  new Authentification($container)
        ]
);
