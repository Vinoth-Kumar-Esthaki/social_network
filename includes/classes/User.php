<?php

class User{
    private $user;
    private $conn;
    public function __construct($conn,$user){
        $this->conn = $conn;
        $user_details_query = mysqli_query($this->conn,"SELECT * FROM user WHERE username='$user'");
        $this->user = mysqli_fetch_array($user_details_query);
    }
    public function getFirstAndLastName(){
        $name = $this->user['first_name']." ".$this->user['last_name'];
        return $name;
    }
    public function getUsername(){
        $username = $this->user['username'];
        return $username;
    }
    public function getProfilePic(){
        $profile_pic = $this->user['profile_pic'];
        return $profile_pic;
    }
    public function getFriendArray(){
        $friend_array = $this->user['friend_array'];
        return $friend_array;
    }
    public function getNumPosts(){
        $username = $this->user['username'];
        $query = mysqli_query($this->conn,"SELECT num_posts FROM user WHERE username='$username'");
        $row = mysqli_fetch_array($query);
        return $row['num_posts'];
    }
    public function setNumPosts($numPost){
        $username = $this->user['username'];
        $query = mysqli_query($this->conn,"UPDATE user SET num_posts='$numPost' WHERE username='$username'");
        return true;
    }
    public function setNumLikes($numLikes){
        $username = $this->user['username'];
        $query = mysqli_query($this->conn,"UPDATE user SET num_likes='$numLikes' WHERE username='$username'");
        return true;
    }
    public function isClosed(){
        $username = $this->user['username'];
        $query = mysqli_query($this->conn,"SELECT user_closed FROM user WHERE username='$username'");
        $row = mysqli_fetch_array($query);

        if($row['user_closed'] =='yes')
            return true;
        else    
            return false;
    }
    public function isFriend($username_to_check){
        $usernameStr =",".$username_to_check.",";
        if((strstr($this->user['friend_array'],$usernameStr)|| $this->user['friend_array'] == $usernameStr)){
            return true;
        }else{
            return false;
        }
    }
    public function didReceivedFriendRequest($user_from){
        $user_to = $this->user['username'];
        $check_request_query = mysqli_query($this->conn,"SELECT * FROM `friend_request` WHERE `user_from`='$user_from' AND `user_to`='$user_to'");
        if(mysqli_num_rows($check_request_query) > 0){
            return true;
        }else{
            return false;
        }
    }
    public function didSendFriendRequest($user_to){
        $user_from = $this->user['username'];
        $check_request_query = mysqli_query($this->conn,"SELECT * FROM `friend_request` WHERE `user_from`='$user_from' AND `user_to`='$user_to'");
        if(mysqli_num_rows($check_request_query) > 0){
            return true;
        }else{
            return false;
        }
    }
    public function removeFriend($user_to_remove){
        $username = $this->user['username'];
        //remove from the other user's friend array
        $query = mysqli_query($this->conn,"SELECT friend_array FROM `user` WHERE `username`='$user_to_remove'");
        $row = mysqli_fetch_array($query);
        $friend_array_username=$row['friend_array'];
        //remove
        $new_friend_array = str_replace($username.",","",$friend_array_username);
        $remove_friend = mysqli_query($this->conn,"UPDATE `user` SET `friend_array`='$new_friend_array' WHERE username='$user_to_remove'" );
        //remove from the logged in user's friend array
        $new_friend_array = str_replace($user_to_remove.",","",$this->user['friend_array']);
        $remove_friend = mysqli_query($this->conn,"UPDATE `user` SET `friend_array`='$new_friend_array' WHERE username='$username'" );
    }
    public function sendFriendRequest($user_to){
        $user_from = $this->user['username'];
        $timestamp = date('Y-m-d H:i:s');
        $query = mysqli_query($this->conn,"INSERT INTO `friend_request` (`user_from`,`user_to`,`timestamp`) VALUES ('$user_from','$user_to','$timestamp') ");

    }
    public function getMutualFriends($user_to_check){
        $mutualFriends =0;
        $user_friend_array = $this->user['friend_array'];
        $user_friend_array_explode =explode(",",$user_friend_array);
        // get $user to check friend array
        $query = mysqli_query($this->conn,"SELECT friend_array FROM `user` WHERE username='$user_to_check'");
        $row =mysqli_fetch_array($query);
        $user_to_check_array = $row['friend_array'];
        $user_to_check_array_explode = explode(",",$user_to_check_array);

        
        $mutualFriendsList = array();

        foreach($user_friend_array_explode as $i){
            foreach($user_to_check_array_explode as $j){
                if($i!="" && $i==$j){
                    $mutualFriendsList[] = $i;
                    $mutualFriends++;
                }
            }
        }
        return array('count'=>$mutualFriends,'list'=>$mutualFriendsList);
    }
}
?>