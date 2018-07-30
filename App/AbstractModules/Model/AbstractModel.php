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

namespace App\AbstractModules\Model;

use Kernel\INTENT\Intent;
use Kernel\INTENT\Intent_Form;
use Kernel\Model\Model;
use Kernel\Tools\Tools;
use function explode;

abstract class AbstractModel extends Model
{

    //get data
    public function find_by_id($id): array
    {
        return $this->getData()->find_by_id($id);
    }

    public function get_idfile($conditon): string
    {
        return $this->getData()->get_idfile($conditon);
    }

    // get ajax
    public function showAjax($mode, $condition): array
    {

        $intent = $this->getData()->select($mode, $condition);
        $entity = ($intent->getEntitysDataTable());
        return Tools::entitys_TO_array($entity);
    }

    // save data
    public function setData($data, $id_perent = 0)
    {

        if (isset($data) && !empty($data)) {
            if ($id_perent === 0) {
                if ($data['id'] == "") {
                    $id_parent = $this->get_setData()->insert($data, Intent::MODE_INSERT);
                } else {
                    $id_parent = $this->get_setData()->update($data, Intent::MODE_UPDATE);
                }
            } else {
                $id_parent = $this->get_setData()->insert_inverse($data, $id_perent, Intent::MODE_INSERT);
            }
            return ($id_parent);
        } else {
            die("rak 3aya9ti");
        }
    }

    public function delete($condition): int
    {
        return $this->get_setData()->delete($condition);
    }

    // get html
    // //



    public function show(array $mode, $condition = true): Intent
    {

        if ($condition !== true) {
            $condition = ["{$this->getTable()}.id" => $condition];
        }
        $intent = $this->getData()->select($mode, $condition);
        return $intent;
    }

    public function show_in(array $mode, $condition = true): Intent
    {

        if ($condition !== true) {
            $condition = explode(",", $condition);
        }
        $intent = $this->getData()->select_in($mode, "{$this->getTable()}.id", $condition);
        return $intent;
    }

    public function show_id($id): Intent_Form
    {
        return $this->getGui()->formDefault(["{$this->getTable()}.id" => $id]);
    }

    /// form
    public function formSelect(): Intent_Form
    {

        $intent = $this->getGui()->formSelect();
        return $intent;
    }

    public function formDefault($conditon): Intent_Form
    {

        $intent = $this->getGui()->formDefault($conditon);
        return $intent;
    }

    public function form($conditon = ""): Intent_Form
    {

        $intent = $this->getGui()->form($conditon);
        return $intent;
    }
}
