<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author wassime
 */

namespace App\Authentification\Comptes\Model;

use App\AbstractModules\Model\AbstractModel;

class Model extends AbstractModel {

    public function login($login, $password) {
// return $this->select(["login" => $login, "password" => $password]);
        $schema = $this->getSchema();

        $compte = $this->prepareQueryAssoc(
                self::Get_QuerySQL()->select()
                        ->from($schema->getNameTable())
                        ->where(["login" => $login])
                        ->prepareQuery());
        if (empty($compte)) {
            $compte = $this->prepareQueryAssoc(
                    self::Get_QuerySQL()->select()
                            ->from($schema->getNameTable())
                            ->where(["email" => $login])
                            ->prepareQuery());
        }
        if (empty($compte)) {
            return [];
        } else {
            return $compte[0];
        }
    }

}
