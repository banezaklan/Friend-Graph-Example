<?php
require_once 'MongoDbCollection.php';
/**
 * Very simple data collection collection class, based on MongoDB data layer.
 */
class UserModelCollection extends MongoDbCollection{
    
    /**
     * Constructor requres established connection, provided by the Data Manager in this example.
     * @param type $dbConnection
     */
    public function __construct($dbConnection) {
        $this->dbConnection = $dbConnection;
        $this->databaseName = 'cargo-media';
        $this->collectionName = 'users';
        parent::__construct();
    }
    
    /**
     * Returns collection of all friends of a given user ID.
     * @param integer $id
     * @return array
     */
    public function getMyFriends($id){
        return $this->mongoDbCollection->find( array(
                        'friends'=> array('$in'=>array($id)) 
                    ) 
                );
    }
    
    /**
     * Returns collection of friends-of-friends of user, who are not already friends with the user.
     * @param integer $id
     * @return array
     */
    public function getMyFriendsOfFriends($id){
        $retVal = array();
        $myFriends = $this->getMyFriends($id);
        foreach ($myFriends as $friend) {
            //$retVal[] = $this->getMyFriendsUnknownFriends($id, $friend['id']);

            $cursor = $this->mongoDbCollection->find( 
                array(
                            'friends'=> array('$in'=>array($friend['id'])),
                            'friends'=> array('$nin'=>array($id) )
                )
            );
            foreach ($cursor as $friendOfFriend) {
                $suggestedFriendsIds = array_map(function ($entry) {
                                                return $entry['id'];
                                       }, $retVal);                
                if( !in_array($friendOfFriend['id'], $suggestedFriendsIds) && $friendOfFriend['id']!=$id ){                       
                    $retVal[] = $friendOfFriend;
                }
            }
        }
        return $retVal;
    }
    
    /**
     * Returns a collection of friends-of-friends, who know 2 or more friends as user, but not the user.
     * @param integer $id
     * @return array
     */
    public function getSuggestedFriends($id){
        $retval = array();
        $me = $this->mongoDbCollection->findOne(array(
                        'id'=>$id
                  ));        
        
        $friendsOfFriends = $this->getMyFriendsOfFriends($id);
        foreach ($friendsOfFriends as $user) {
            $intersection = array_intersect( $user['friends'], $me['friends'] );
            if(count($intersection)>=2){
                $retval[] = $user;
            }
        }
        
        return $retval;
    }
    
}

