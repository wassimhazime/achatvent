<?php

use App\AbstractModules\phinix_db\Autorisation;

class AutorisationComptes extends Autorisation {

    public function change() {
        $this->create_autorisation("Comptes");
    }

}
