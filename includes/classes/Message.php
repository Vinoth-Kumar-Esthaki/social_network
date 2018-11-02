<?php

class Message{
    private $user_obj;
    private $conn;
    public function __construct($conn,$user){
        $this->conn = $conn;
        $this->user_obj = new User($conn,$user);
    }
    public function getMostRecentUser($userLoggedIn){
        $userLoggedIn = $this->user_obj->getUsername();
        $query = mysqli_query($this->conn,"SELECT * FROM message WHERE user_to='$userLoggedIn' OR user_from='$userLoggedIn' ORDER BY id DESC LIMIT 1");

        if(mysqli_num_rows($query) == 0){
            return false;
        }
        $row = mysqli_fetch_array($query);
        $user_to =$row['user_to'];
        $user_from = $row['user_from'];

        if($user_to != $userLoggedIn){
            return $user_to;
        }else{
            return $user_from;
        }
    }
}
?>