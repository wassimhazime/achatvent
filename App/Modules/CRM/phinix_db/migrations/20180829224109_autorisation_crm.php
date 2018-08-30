<?php

use App\AbstractModules\phinix_db\Autorisation;

class AutorisationCrm extends Autorisation {

    public function change() {
        $this->create_autorisation("CRM");
    }

}
