<?php

use Phinx\Seed\AbstractSeed;

class ModePaiement extends AbstractSeed {

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run() {
      
        $faker = Faker\Factory::create('fr_FR');

        $date = date("Y-m-d H:i:s", $faker->unixTime('now'));
        $data = [[
        'mode$paiement' => "Chèque",
        "date_ajoute" => $date,
        "date_modifier" => $date
            ], [
                'mode$paiement' => "Espèces",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                'mode$paiement' => "Carte bancaire",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                'mode$paiement' => "Virement bancaire",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                'mode$paiement' => "Prélèvement",
                "date_ajoute" => $date,
                "date_modifier" => $date
            ], [
                'mode$paiement' => "EFFE",
                "date_ajoute" => $date,
                "date_modifier" => $date
        ]];

        $this->table('mode$paiement')->insert($data)->save();
    }

}
