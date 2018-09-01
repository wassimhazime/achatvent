<?php

use App\Modules\Achats\AchatsModule;
use App\Modules\CRM\CRMModule;
use App\Modules\Statistique\StatistiqueModule;
use App\Modules\Transactions\TransactionsModule;
use App\Modules\Ventes\VentesModule;

// add module
$app->addModule(StatistiqueModule::class);
$app->addModule(CRMModule::class);
$app->addModule(AchatsModule::class);
$app->addModule(VentesModule::class);
$app->addModule(TransactionsModule::class, [
    new \App\Middleware\Authentification()
        ]
);
