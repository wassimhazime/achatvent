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
interface NamesRouteInterface {

    public function set_NameModule(string $nameModule = "");

    public function ajax(): string;

    public function files(): string;

    public function send(): string;

    public function show(): string;
}
