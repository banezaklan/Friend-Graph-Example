<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DataManagerTest extends PHPUnit_Framework_TestCase {

    
    public function testgetDatabaseConnection() {
        $dm = new DataManager();
        $this->assertEquals(is_a($dm, 'DataManager'),true); 
        $conn = $dm->getDatabaseConnection();
        $this->assertEquals(is_a($conn,'Mongo'),true);
    }
    
    public function testgetRemoteSourceData(){
        $dm = new DataManager();
        $json = $dm->getRemoteSourceData();
        $this->assertEquals(is_array($json),true); 
    }

}
