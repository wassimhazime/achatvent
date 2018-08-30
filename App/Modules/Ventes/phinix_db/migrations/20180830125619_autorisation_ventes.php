<?php

use App\AbstractModules\phinix_db\Autorisation;

class AutorisationVentes extends Autorisation {

    public function change() {
        $this->create_autorisation("Ventes");
    }

}
