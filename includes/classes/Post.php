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
            $_POST =array();

        }
    }
    
    public function loadPostsFriends($data,$limit){
        $page = $data['page'];
        $userLoggedIn = $this->user_obj->getUsername();

        if($page == 1)
            $start = 0;
        else    
            $start = ($page-1)*$limit;


        $str =""; //output
        $data_query = mysqli_query($this->conn,"SELECT * FROM post WHERE deleted='no' ORDER BY id DESC");

        if(mysqli_num_rows($data_query) > 0){
            $num_iterations = 0; // number of results checked
            $count =1;

            while($row = mysqli_fetch_array($data_query)){
                $id = $row['id'];
                $body = $row['post'];
                $added_by = $row['created_by'];
                $date_time = $row['created_on'];
                // prepare user_to string  so it can be included  if not posted to any user
                if($row['posted_to'] == 'none'){
                    $user_to="";
                }else{
                    $user_to_obj =new User($this->conn,$row['posted_to']);
                    $user_to_name = $user_to_obj->getFirstAndLastName();
                    $user_to ="<a href='".$row['posted_to']."'>".$user_to_name."</a>";
                }
                //check if the user who posted have an active account
                $added_by_obj = new User($this->conn,$added_by);
                $added_by_pic = $added_by_obj->getProfilePic();
                $added_by_name = $added_by_obj->getFirstAndLastName();
    
                if($added_by_obj->isClosed()){
                    continue;
                }

                $user_logged_obj = new User($this->conn,$userLoggedIn);
            
                if($user_logged_obj->isFriend($added_by)){
                    if($num_iterations++ < $start){
                        continue;
                    }
                    if($count > $limit){
                        break;
                    }else{
                        $count++;
                    }
                    ?>
                        <script>
                                function toggle<?php echo $id;?>(){
                                    var element = document.getElementById("toggleComment<?php echo $id;?>");
                                    if(element.style.display == "block"){
                                            element.style.display="none";
                                        }else{
                                            element.style.display="block";
                                        }
                                    }
                        </script>
                    <?php
    
                    //time frame
                    $date_time_now = date("Y-m-d H:i:s");
                    $start_date =new DateTime($date_time);
                    $end_date = new DateTime($date_time_now);
                    $interval = $start_date->diff($end_date);
                    if($interval->y >=1){
                        if($interval->y ==1){
                            $time_msg = $interval->y." year ago"; // 1 year ago
                        }else{
                            $time_msg = $interval->y." years ago"; // more than 1 year ago
                        }
                    }else if($interval->m >=1){
                        if($interval->d ==0){
                            $days = " ago";
                        }else if($interval->d ==1){
                            $days =$interval->d." day ago";
                        }else{
                            $days =$interval->d." days ago";
                        }
        
                        if($interval->m == 1){
                            $time_message =$interval->m." month".$days;
                        }else{
                            $time_message =$interval->m." months".$days;
                        }
                    }else if($interval->d >=1){
                        if($interval->d ==1){
                            $time_message ="Yesterday";
                        }else{
                            $time_message =$interval->d." days ago";
                        }
                    }else if($interval->h >=1){
                        if($interval->h ==1){
                            $time_message =$interval->h." hour ago";
                        }else{
                            $time_message =$interval->h." hours ago";
                        }
                    }
                    else if($interval->i >=1){
                        if($interval->i ==1){
                            $time_message =$interval->i." minute ago";
                        }else{
                            $time_message =$interval->i." minutes ago";
                        }
                    }else{
                        if($interval->s < 30){
                            $time_message ="Just now";
                        }else{
                            $time_message =$interval->s." seconds ago";
                        }
                    }
                    //post html
                    $str.="
                        <div class='status_post' onClick='javascript:toggle$id()'>
                            <div class='post_profile_pic'>
                                <img src='$added_by_pic' alt='profile pic' width='50'/>
                            </div>
                            <div class='posted_by' style='color:#ACACAC;'>
                                <a href='$added_by'> $added_by_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp; $time_message
                            </div>
                            <div id='post_body'>
                                $body
                                <br>
                            </div>
                        </div>
                        <div class='post_comment' id='toggleComment$id' style='display:none'>
                            <iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder=0 frameborder=0 width='800px' style='width:600px;'></iframe>
                        </div>
                        <hr>";

                } // end if condition
                
            }//end while loop     
            if($count > $limit){
                $str .="<input type='hidden' class='nextPage' value='".($page+1)."'/> <input type='hidden' class='noMorePosts' value='false'/>";
            }else{
                $str .="<input type='hidden' class='noMorePosts' value='true'/>
                <p style='text-align:center;'>No more posts to show !</p> ";
            }
        }   
        return $str;
    }
}
?>