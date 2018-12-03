<?php

use Kernel\Conevert\HTML_Phinx;
use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

class Packs extends AbstractMigration {

    public function change() {
        $this->table("packs", HTML_Phinx::id_default())
                ->addColumn(HTML_Phinx::id())
                ->addColumn(HTML_Phinx::text_master('nom$pack'))
                ->addColumn(HTML_Phinx::textarea('Description'))
                ->addColumn(HTML_Phinx::number('Prix$d$achat$TTC'))
                ->addColumn(HTML_Phinx::number('Prix$de$vente$TTC'))
                ->addColumn(HTML_Phinx::checkBox('Disponible$dans$les$ventes'))
                ->addColumn(HTML_Phinx::checkBox('Disponible$dans$les$achats'))
                ->addColumn(HTML_Phinx::datetime('date_ajoute'))
                ->addColumn(HTML_Phinx::datetime('date_modifier'))
                ->create();

        HTML_Phinx::relation('packs', 'pack', $this->getAdapter());
    }

}
