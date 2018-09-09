<?php
if(isset($_POST['login_button'])){
	$email = filter_var($_POST['log_email'],FILTER_SANITIZE_EMAIL); // sanitize email
	$_SESSION['log_email'] = $email;//store email in session

	$password =md5($_POST['log_password']);//encrypt the password

	$check_database_query = mysqli_query($conn,"SELECT * FROM user WHERE email='$email' AND password='$password'");
	$check_login_query = mysqli_num_rows($check_database_query);

	if($check_login_query ==1){
		$row = mysqli_fetch_array($check_database_query);

		$username = $row['username'];
		$profile_pic = $row['profile_pic'];

		$_SESSION['username'] = $username;
		$_SESSION['profile_pic'] = $profile_pic;
		$_SESSION['success'] = true;
		
		$user_closed_query = mysqli_query($conn,"SELECT * FROM user WHERE email='$email' AND user_closed='yes'");
		if(mysqli_num_rows($user_closed_query) ==1){
			$reopen_account=mysqli_query($conn,"UPDATE user SET user_closed='no' WHERE email='$email'");
		}

		header("Location:index.php");
		exit();
	}else{
		$_SESSION['success'] = false;
		$error_array['log_failed'] ="Email or Password is incorrect !";
	}

}
?>