<?php
require_once '../../config/config.php';
require_once '../classes/User.php';
require_once '../classes/Post.php';


if(isset($_POST['post_body'])){
    
    $post = new Post($conn,$_POST['user_from']);
    $post->submitPost($_POST['post_body'],$_POST['user_to']);

}

?>