<?php

use App\AbstractModules\phinix_db\Autorisation;

class AutorisationStatistique extends Autorisation {

    public function change() {
        $this->create_autorisation("Statistique");
    }

}
