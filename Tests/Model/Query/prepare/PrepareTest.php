<?php

use Kernel\Model\Query\QuerySQL;
use PHPUnit\Framework\TestCase;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PrepareTest
 *
 * @author wassime
 */
class PrepareTest extends TestCase{
    
    
    public function testInsert() {
        $query=(new QuerySQL())->insertInto("client")
                ->value(["nom"=>"wassim","age"=>20])
                ->prepareQuery();
        
        $prepare=$query["prepare"];
        $execute=$query["execute"];
         $this->assertEquals($prepare, " INSERT INTO client (`nom`, `age`) VALUES (? , ?) ");
       
         $this->assertArraySubset(["wassim","20"], $execute);
       
    }
    
       public function testUpdate() {
        $query=(new QuerySQL())->update("client")
                ->value(["nom"=>"wassim","age"=>20])->where(["id"=>"6"])
                ->prepareQuery();
        
        $prepare=$query["prepare"];
        $execute=$query["execute"];
         $this->assertEquals($prepare, "UPDATE  client  (`nom`, `age`) VALUES (? , ?)  WHERE ( id  = ? )");
       
         $this->assertArraySubset(["wassim","20"], $execute);
       
    }
    
}
