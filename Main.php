<?php
/*
 * By Branislav Zaklan, January 2014.
 */


require_once 'DataManager.php';
require_once 'MongoDbCollection.php';
require_once 'UserModelCollection.php';




/** This part handles command line parameters. **/

if(isset($argv) && isset($argv[1]) && isset($argv[2])){
    $argCommand = $argv[1];
    $argUserId = (integer)$argv[2];

    $dm = new DataManager();
    $dbConn = $dm->getDatabaseConnection();
    $userCollection = new UserModelCollection($dbConn);
    
    switch ($argCommand) {
        case "f":
            $cursor = $userCollection->getMyFriends($argUserId);
            
            break;
        case "fof":
            $cursor = $userCollection->getMyFriendsOfFriends($argUserId);

            break;
        case "fs":
            $cursor = $userCollection->getSuggestedFriends($argUserId);

            break;        
        default:
            echo "Unknown command. Only f,fof,fs  \r\n";
            break;
    }
    
    /* prints out collection records */
    if(isset($cursor)){
        foreach ($cursor as $row) {
            echo $row['firstName']." ".$row['surname']." [".$row['id']."]\r\n";

        }        
    }

    
}else{
    echo "Wrong parameters. Usage: php main.php [f,fof,fs] [user id]  \r\n";
}


echo "\r\n";
echo "All done!\r\n";