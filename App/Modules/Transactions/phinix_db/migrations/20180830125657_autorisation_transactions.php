<?php

use App\AbstractModules\phinix_db\Autorisation;

class AutorisationTransactions extends Autorisation {

    public function change() {
        $this->create_autorisation("Transactions");
    }

}
