<?php

use App\Authentification\Autorisation_TablePhinix;

class AutorisationStatistique extends Autorisation_TablePhinix {

    public function change() {
        $this->create_autorisation("Statistique");
    }

}
