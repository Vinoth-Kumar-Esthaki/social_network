<?php
require_once('includes/header.php');

//obj
$message_obj = new Message($conn,$loggedInUser);

//$user_to = isset($_GET['u']) ?? $message_obj->getMostRecentUser();

if($user_to==false){
    $user_to ="new";
}


?>