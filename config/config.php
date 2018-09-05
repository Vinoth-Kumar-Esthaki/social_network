<?php
ob_start();//starts output bufferring
session_start(); //start the session

$timezone = date_default_timezone_set("Asia/Kolkata");
$conn = mysqli_connect("localhost","root","admin","social_network");

if(mysqli_connect_errno()){
	echo "Failed to connect ".mysqli_connect_errno();
}

?>