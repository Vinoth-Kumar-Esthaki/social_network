<?php
class Post{
    private $user_obj;
    private $conn;
    public function __construct($conn,$user){
        $this->conn = $conn;
        $this->user_obj = new User($conn,$user);
    }
    public function submitPost($body,$user_to){
        $body= strip_tags($body);//remove html tags
        $body= mysqli_real_escape_string($this->conn,$body);
        $check_empty = preg_replace("/\s+/","",$body); // deletes spaces
        if($check_empty!=""){
            //current date and time
            $date_added = date("Y-m-d H:i:s");
            //Get Username
            $added_by = $this->user_obj->getUsername();
            //if user is not on own profile , user_to is none
            if($user_to == $added_by){
                $user_to ="none";
            }
            //insert post
            $query = mysqli_query($this->conn,"INSERT INTO post (`post`,`created_by`,`posted_to`,`created_on`,`user_closed`,`deleted`,`likes`) VALUES ('$body','$added_by','$user_to','$date_added','no','no','0')");
            $insert_id = mysqli_insert_id($this->conn);
            //insert notification
            //update post count for user
            $num_post = $this->user_obj->getNumPosts();
            $num_post++;
            $this->user_obj->setNumPosts($num_post);

        }
    }
}
?>