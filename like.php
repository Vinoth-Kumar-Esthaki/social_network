<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">

</head>
<body>
<style type="text/css">
        *{
            font-size:15px;
            font-family:Arial ,Helvetica,sans-serif;
        }
        body{
            
            background-color:#fff;
            overflow:hidden;
        }
        form{
            position:absolute;
            top:0;
        }
       
        
    </style>
    <?php
        require_once 'config/config.php';
        require_once 'includes/classes/Utils.php';
        require_once 'includes/classes/User.php';
	    require_once 'includes/classes/Post.php';

        $loginFlag =  isset($_SESSION['success']) ? $_SESSION['success'] : false;
        
        if($loginFlag){
            $loggedInUser = isset($_SESSION['username']) ? $_SESSION['username'] :"";
        
            $user_info_query = mysqli_query($conn,"SELECT * FROM user WHERE username='$loggedInUser'");
            $userRow = mysqli_fetch_array($user_info_query);
        
        
        }else{
            header("Location:register.php");
        }
        
        if(isset($_GET['post_id'])){
            $post_id = $_GET['post_id'];            
        }
        $get_likes = mysqli_query($conn,"SELECT likes,created_by FROM post WHERE id='$post_id'");
        $row = mysqli_fetch_array($get_likes);
        $total_likes = $row['likes'];
        $user_liked = $row['created_by'];
        //user details query
        $user_details_query = mysqli_query($conn,"SELECT * FROM user WHERE username='$user_liked'");
        $row =mysqli_fetch_array($user_details_query);
        $total_user_likes = $row['num_likes'];
        //like button
        if(isset($_POST['like_button'])){
            //increment the total likes for post
            $total_likes++;
            $post_obj = new Post($conn,$loggedInUser);
            $post_obj->setLikes($total_likes,$post_id);
            //increment the total likes for user
            $total_user_likes++;
            $user_obj = new User($conn,$user_liked);
            $user_obj->setNumLikes($total_user_likes);
            //insert into likes table
            $insert_likes = mysqli_query($conn,"INSERT INTO likes (`username`, `post_id`) VALUES ('$loggedInUser','$post_id')");
            //insert notification
        }
        //unlike
        if(isset($_POST['unlike_button'])){
            $total_likes --;
            $post_obj = new Post($conn,$loggedInUser);
            $post_obj->setLikes($total_likes,$post_id);
            //increment the total likes for user
            $total_user_likes--;
            $user_obj = new User($conn,$user_liked);
            $user_obj->setNumLikes($total_user_likes);
            //Delete likes from the table
            $delete_likes = mysqli_query($conn,"DELETE FROM likes WHERE username='$loggedInUser' AND post_id='$post_id'");

        }
        //check for the previous likes
        $check_query =mysqli_query($conn,"SELECT * FROM likes WHERE username ='$loggedInUser' AND post_id='$post_id'");
        $num_rows = mysqli_num_rows($check_query);
        if($num_rows > 0){
            echo '<form action="like.php?post_id='.$post_id.'" method="POST">
                  <input type="submit" class="comment_like" name="unlike_button" value="unlike">
                  <div class="like_value">
                   &nbsp;&nbsp;Likes ('.$total_likes.')
                  </div>
                </form> ';
        }else{
            echo '<form action="like.php?post_id='.$post_id.'" method="POST">
            <input type="submit" class="comment_like" name="like_button" value="like">
            <div class="like_value">
                &nbsp;&nbsp;Likes ('.$total_likes.')
            </div>
          </form> ';
        }

    ?>
</body>
</html>