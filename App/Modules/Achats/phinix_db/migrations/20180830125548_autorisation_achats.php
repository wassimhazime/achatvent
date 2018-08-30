<?php

use App\AbstractModules\phinix_db\Autorisation;

class AutorisationAchats extends Autorisation {

    public function change() {
        
        $this->create_autorisation("Achats");
    }

}
