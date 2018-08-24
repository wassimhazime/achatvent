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
        $data = [];
        $faker = Faker\Factory::create('fr_FR');
        for ($index = 0; $index < 10; $index++) {
            $date = date("Y-m-d H:i:s", $faker->unixTime('now'));
            $data[] = [
                'mode$paiement' => $faker->word,
              
                "date_ajoute" => $date,
                "date_modifier" => $date
            ];
        }
        $this->table('mode$paiement')->insert($data)->save();
    }

}
