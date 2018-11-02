<?php
require_once '../../config/config.php';

if(isset($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    $result = isset($_POST['result']) ? $_POST['result']:false;

    if($post_id!="" && $result){
        $query = mysqli_query($conn,"UPDATE `post` SET deleted='yes' WHERE id='$post_id'");
        return true;
    }    
}

?>