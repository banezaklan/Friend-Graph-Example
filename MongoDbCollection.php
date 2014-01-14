<?php
/**
 * Class represents a very simple apstraction of MongoDb collection data layer.
 * It requres already established connection.
 */
abstract class MongoDbCollection{
    
    protected $dbConnection = null;
    protected $mongoDbCollection = null;
    public $databaseName = "";
    public $collectionName = "";
    
    public function __construct() {
        
        $this->mongoDbCollection = $this->dbConnection->selectCollection($this->databaseName, $this->collectionName);
    }    
    
    public function insertRecord(stdClass $data){
        
        $mongoDbInsertOptions = array(
            'fsync' => true,
            'timeout' => 10000,
            'safe' => true
        );
        $result = $this->mongoDbCollection->insert($data,$mongoDbInsertOptions);
    }
    
    public function clear(){
        $result = $this->mongoDbCollection->remove();
    }
    
}

