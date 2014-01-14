<?php

/**
 * Class used to establish connection with MongoDB database and to import data from json doc URL. 
 * The import was performed just once, so no need to call it repeatedly. 
 */
class DataManager{
    
    private $mongoDbConnStr = "mongodb://testuser:test2014@ds061318.mongolab.com:61318/cargo-media";
    
    private $remoteSourceDataUrl = "http://www.cargomedia.ch/task/social-graph/data.json";
    /**
     * @return \Mongo
     */
    public function getDatabaseConnection(){
        $connection = new Mongo($this->mongoDbConnStr);
        return $connection;
    }
    
    public function getRemoteSourceData(){
        $json = file_get_contents($this->remoteSourceDataUrl);
        $data = json_decode($json);        
        return $data;
    }
    
}