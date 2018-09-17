<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
    <?php
        require_once 'config/config.php';
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
        
    ?>
    <script>
        function toggle(id){
            var element = document.getElementById("comment_section");
            if(element.style.display == "block"){
                element.style.display="none";
            }else{
                element.style.display="block";
            }
        }
    </script>
    <?php   
        
        //get id of the post
        if(isset($_GET['post_id'])){
            $post_id = $_GET['post_id'];            
        }
        $user_query = mysqli_query($conn,"SELECT created_by,posted_to FROM post WHERE id='$post_id'");
        $row = mysqli_fetch_array($user_query);

        $posted_to = $row['created_by'];

        if(isset($_POST['postComment'.$post_id])){
            $post_body = $_POST['post_body'];
            $post_body = mysqli_escape_string($conn,$post_body);
            $date_time_now =date("Y-m-d H:i:s");

            //echo "INSERT INTO comment (`post_body`, `posted_by`, `posted_to`, `created_on`, `removed`, `post_id`) VALUES('$post_body','$loggedInUser','$posted_to','$date_time_now','no','$post_id')";
            $insert_post = mysqli_query($conn,"INSERT INTO comment (`post_body`, `posted_by`, `posted_to`, `created_on`, `removed`, `post_id`) VALUES('$post_body','$loggedInUser','$posted_to','$date_time_now','no','$post_id')");

            echo "<p> Comment Posted !</p>";
        }

    ?>
    <form action="comment_frame.php?post_id=<?php echo $post_id;?>" method="POST" id="comment_form" name="postComment<?php echo $post_id;?>"> 
        <textarea name="post_body" id="" cols="50" rows="5"></textarea>
        <input type="submit" name="postComment<?php echo $post_id ; ?>" value="Comment"/>
    </form>

    <!-- load comments -->
        
    
</body>
</html>