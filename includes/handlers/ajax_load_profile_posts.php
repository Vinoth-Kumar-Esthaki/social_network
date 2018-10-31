<?php
require_once '../../config/config.php';
require_once '../classes/User.php';
require_once '../classes/Post.php';

$limit =5; // number of posts to be loaded per call
$posts = new Post($conn,$_REQUEST['userLoggedIn']);
echo $posts->loadProfilePosts($_REQUEST,$limit);


?>