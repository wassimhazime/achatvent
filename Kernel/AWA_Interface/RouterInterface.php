<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author wassime
 */

namespace Kernel\AWA_Interface;

use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface {

    public function get(string $url, callable $callable, string $name);

    public function post(string $url, callable $callable, string $name);

    public function generateUri($name, array $substitutions = [], array $options = []);

    public function match(ServerRequestInterface $request);
}
