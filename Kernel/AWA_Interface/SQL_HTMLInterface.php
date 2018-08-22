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
interface SQL_HTMLInterface {
    /*
      'varchar(20)' => 'tel',
      'varchar(150)' => 'email',
      'varchar(200)' => 'text',
      'varchar(201)' => 'text',
      'varchar(250)' => 'file',
      'text' => 'textarea',
      'date' => 'date',
      'tinyint(1)' => 'checkBox',
      'int(12)' => 'number',
      'int(11)' => 'select',
      'int(10)' => 'hidden'
     */

    const HTML_SQL = 
                ["tel" =>        ["typeHtml"=>"tel",   "typePhinix" => "string",   "options" => ['limit' => 20, 'null' => true]],
                "email" =>       ["typeHtml"=>"email",   "typePhinix" => "string",   "options" => ['limit' => 150, 'null' => true]],
                "text_master" => ["typeHtml"=>"text",   "typePhinix" => "string",   "options" => ['limit' => 200]],
                "text" =>        ["typeHtml"=>"text",      "typePhinix" => "string",   "options" => ['limit' => 201, 'null' => true]],
                "file" =>        ["typeHtml"=>"file",       "typePhinix" => "string",   "options" => ['limit' => 250, 'null' => true]],
                "textarea" =>    ["typeHtml"=>"textarea",   "typePhinix" => "text",     "options" => ['null' => true]],
                "date" =>        ["typeHtml"=>"date",        "typePhinix" => "date",     "options" => []],
                "checkBox" =>    ["typeHtml"=>"checkBox",   "typePhinix" => "integer",   "options" => ['limit' => 4]],
                "number" =>      ["typeHtml"=>"number",      "typePhinix" => "integer",   "options" => ['limit' => 12]],
                "select" =>      ["typeHtml"=>"select",   "typePhinix" => "integer",   "options" => ['limit' => 11]],
                "id" =>          ["typeHtml"=>"hidden",   "typePhinix" => "integer",   "options" => ['limit' => 10, 'identity' => true]],
                "add_update" =>  ["typeHtml"=>"hidden",   "typePhinix" => "datetime",   "options" => [] ] 
                    ];

}
