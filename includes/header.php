<?php
require_once 'config/config.php';

$loginFlag =  isset($_SESSION['success']) ? $_SESSION['success'] : false;

if($loginFlag){
	$loggedInUser = isset($_SESSION['username']) ? $_SESSION['username'] :"";

	$user_info_query = mysqli_query($conn,"SELECT * FROM user WHERE username='$loggedInUser'");
	$userRow = mysqli_fetch_array($user_info_query);


}else{
	header("Location:register.php");
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Social Network</title>
	<!-- css -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


	<!-- javascript -->
	<script type="text/javascript" src="assets/jquery/jquery.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="top-bar">
		<div class="logo">
				<a href="#">Social Network </a>
		</div>
		<nav>
				<a href="#">
					<?php
						echo $userRow['first_name']." ". $userRow['last_name'];
					?>
				</a>
				<a href="index.php">
					
					<i class="fa fa-home fa-lg"></i>
				</a>
				<a href="#">
					<i class="fa fa-envelope fa-lg"></i>
				</a>
				<a href="#">
					<i class="fa fa-bell fa-lg"></i>
				</a>
				<a href="#">
					<i class="fa fa-user fa-lg"></i>
				</a>
				<a href="#">
					<i class="fa fa-cog fa-lg"></i>
				</a>
		</nav>
	</div>