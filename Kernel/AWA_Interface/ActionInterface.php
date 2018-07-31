<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Kernel\AWA_Interface;

/**
 *
 * @author wassime
 */
interface ActionInterface {

    public function add(): string;

    public function update(): string;

    public function delete(): string;

    public function show(): string;

    public function message(): string;

    function setAction($action);

    public function is_add(): bool;

    public function is_update(): bool;

    public function is_delete(): bool;

    public function is_show(): bool;

    public function is_message(): bool;

    public function is_index(): bool;
}
