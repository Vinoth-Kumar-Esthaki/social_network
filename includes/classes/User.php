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
}
?>