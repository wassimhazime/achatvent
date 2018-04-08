<?php

namespace Kernel\Model\Entitys;

use Kernel\INTENT\Intent;

class EntitysDataTable extends abstractEntitys
{

    private $DataJOIN = array();
  

//add item enfant
    

    public function setDataJOIN($key, $enfant)
    {
        $this->DataJOIN[$key] = $enfant;
    }

    public function getDataJOIN($key = null)
    {
        if ($key == null) {
            return $this->DataJOIN;
        } else {
            return $this->DataJOIN[$key];
        }
    }

    public function set(array $data): array
    {
        if (Intent::isAssoc($data)) {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
        }
        return [$this];
    }
}
