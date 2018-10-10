<?php
require_once('includes/header.php');
require_once 'includes/classes/User.php';
require_once 'includes/classes/Post.php';

?>

<div class="main_column column" id="main_column">
    <h4>Friend Requests</h4>
    <?php
    $query = mysqli_query($conn,"SELECT * FROM `friend_request` WHERE `user_to`='$loggedInUser'");
    if(mysqli_num_rows($query) == 0){
        echo "You have no friend requests at this time !";
    }else{
        while($row = mysqli_fetch_array($query)){
            $user_from = $row['user_from'];
            
            $user_from_obj = new User($conn,$user_from);

            echo $user_from_obj->getFirstAndLastName()." sent you a friend request";

            $user_from_friend_array =$user_from_obj->getFriendArray();
            //accept request
            if(isset($_POST['accept_request'.$user_from])){
                // add friend 
                $add_friend_query = mysqli_query($conn,"UPDATE `user` SET `friend_array`=CONCAT(`friend_array`,'$user_from,') WHERE username='$loggedInUser'");
                $add_friend_query = mysqli_query($conn,"UPDATE `user` SET `friend_array`=CONCAT(`friend_array`,'$loggedInUser,') WHERE username='$user_from'");
                //delete request from friend request table
                $delete_query =mysqli_query($conn,"DELETE FROM `friend_request` WHERE user_to='$loggedInUser' AND user_from='$user_from'");
                echo "You are now friends !";
                header('Location:request.php');
            }

            if(isset($_POST['ignore_request'.$user_from])){
                //delete request from friend request table
                $delete_query =mysqli_query($conn,"DELETE FROM `friend_request` WHERE user_to='$loggedInUser' AND user_from='$user_from'");
                echo "Request ignored !";
                header('Location:request.php');
            }
            ?>
            <form action="request.php" method="POST">
                <input type="submit" name="accept_request<?php echo $user_from;?>" class="btn btn-success accept_button" value="Accept"/>
                <input type="submit" name="ignore_request<?php echo $user_from;?>" class="btn btn-danger ignore_button" value="Ignore"/>
            </form>    
            <?php
        }
    }
    ?>
</div>