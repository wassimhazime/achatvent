<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\AWA_Interface\Base_Donnee;

use Kernel\Model\Entitys\EntitysDataTable;
use Kernel\Model\Entitys\EntitysSchema;

/**
 *
 * @author wassime
 */
interface SelectInterface {

    /**
     * has id return true | false
     * @param string $id
     * @return bool
     */
    public function is_id(string $id, $schema = null): bool;

    /**
     * recherche par id
     * @param type $id
     * @param EntitysSchema $schema 
     * @param array $mode 
     * @return EntitysDataTable
     */
    public function find_by_id($id, $schema, array $mode = []): EntitysDataTable;

    /**
     * get id (exmple:<a class="btn "  role="button" href="/CRM/files/clients_2018-08-01-16-32-12"  data-regex="/clients_2018-08-01-16-32-12/" > <spam class="glyphicon glyphicon-download-alt"></spam> 6</a>)
     * set to table de file upload
     * 
     * @param string $id
     * @return string
     */
    public function get_idfile(string $id_save): string;

    /**
     * pour select data to table
     * @param array $mode
     * @param type $id
     * @param EntitysSchema $schema
     * @return array
     */
    public function select(array $mode, $id = true, $schema = null): array;

    /**
     * select donnee simple return array assoc
     * @param array $fields
     * @param type $id
     * @param EntitysSchema $schema
     * @return array assoc
     */
    public function select_simple(array $fields, $id = true, $schema = null): array;

    /**
     * pour sele data in range 
     * @param array $mode
     * @param string|array $rangeID
     * @param EntitysSchema $schema
     * @return array EntitysDataTable
     */
    public function select_in(array $mode, $rangeID, $schema = null): array;

    /**
     * select data BETWEEN 2 value in id
     * @param array $mode
     * @param int $valeur1
     * @param int $valeur2
     * @param EntitysSchema $schema
     * @return array EntitysDataTable
     */
    public function select_BETWEEN(array $mode, int $valeur1, int $valeur2, $schema = null): array;
}
