<?php
// declaring variables

$fname ="";//first name
$lname ="";//last name

$em = "";//email
$em2 ="";//email 2

$password ="";//password
$password2="";//password2

$date ="";//sign up date
$error_array=$success_array= array(); // Holds any error messages

if(isset($_POST['register_button'])){
	//registration form values
	//first name
	$fname = strip_tags($_POST['reg_fname']); // remove html tags
	$fname = str_replace(" ", "", $fname); // remove spaces
	$fname = ucfirst(strtolower($fname)); //uppercase first letter
	$_SESSION['reg_fname'] = $fname; // store first name in session
	//last name
	$lname = strip_tags($_POST['reg_lname']); // remove html tags
	$lname = str_replace(" ", "", $lname);// remove spaces
	$lname = ucfirst(strtolower($lname)); // uppercase first letter
	$_SESSION['reg_lname'] = $lname; // store last name in session
	//email
	$em = strip_tags($_POST['reg_email']); // remove html tags
	$em = str_replace(" ", "", $em);// remove spaces
	$_SESSION['reg_email'] = $em; // stores email in session
	//email 2
	$em2 = strip_tags($_POST['reg_email2']); // remove html tags
	$em2 = str_replace(" ", "", $em2);// remove spaces
	$_SESSION['reg_email2'] = $em2; // stroes email2 in session
	//password
	$password = strip_tags($_POST['reg_password']);//remove html tags
	$password2 = strip_tags($_POST['reg_password2']);//remove html tags
	//Date
	$date = date("Y-m-d"); // current date
	//email validation
	if($em == $em2){
		// check if email is in valid format
		if(filter_var($em,FILTER_VALIDATE_EMAIL)){
			$em =filter_var($em,FILTER_VALIDATE_EMAIL);
			// check if email already exist
			$e_check = mysqli_query($conn,"SELECT email from user WHERE email='$em'");
			//count the number of rows returned
			$num_rows = mysqli_num_rows($e_check);

			if($num_rows > 0){
				$error_array['e_exist'] = "Email already in use <br>";
			}

		}else{
			$error_array['e_invalid'] = "Invalid email format <br>";
		}

	}else{
		$error_array['e_match'] = "Email Doesn't match <br>";
	}

	// first name validation
	if(strlen($fname) > 25 || strlen($fname) <=2){
		$error_array['f_invalid'] ="Your first name must be between 2 and 25 characters<br>";
	}
	// last name validation
	if(strlen($lname) > 25 || strlen($lname) <=2){
		$error_array['l_invalid'] = "Your last name must be between 2 and 25 characters<br>";
	}
	//password validation
	if($password != $password2){
		$error_array['p_match'] ="Your password is not matching ! <br>";
	}else{
		if(preg_match('/[^A-Za-z0-9]/', $password)){
			$error_array['p_format'] = "Password should only contain alphabets and numbers <br>";
		}
	}
	// password length validation
	if(strlen($password) > 30 || strlen($password) < 5){
		$error_array['p_invalid'] ="Your password must be within 5 and 30 characters long <br>";
	}

	if(empty($error_array)){
		//proceed
		$password = md5($password); // encrypt the password for storing
		//generate username by concatenating first name and last name
		$username = strtolower($fname."_".$lname);
		//check if user name exist
		$check_username_exist = mysqli_query($conn,"SELECT username FROM user WHERE username='$username'");
		$i=0;
		//if user name exist add a number
		while(mysqli_num_rows($check_username_exist)!=0){
			$i++;
			$username = $username."_".$i;
			$check_username_exist = mysqli_query($conn,"SELECT username FROM user WHERE username='$username'");
		}
		//profile picture assignment
		$defaults = "head_alizarin.png,head_amethyst.png, head_belize_hole.png, head_carrot.png, head_deep_blue.png, head_emerald.png, head_green_sea.png, head_nephritis.png, head_pete_river.png, head_pomegranate.png, head_pumpkin.png, head_red.png, head_sun_flower.png, head_turqoise.png, head_wet_asphalt.png, head_wisteria.png";
		$defaults_arr = explode(",",$defaults);
		$random = rand(0, count($defaults_arr)-1);
		$profile_pic = "assets/images/profile_pics/defaults/".trim($defaults_arr[$random]);

		// create user
		
		$query = mysqli_query($conn,"INSERT INTO user (`first_name`, `last_name`, `username`, `email`, `password`, `signup_date`, `profile_pic`, `num_posts`, `num_likes`, `user_closed`,`friend_array`) VALUES('$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','no',',')");

		$success_array['success'] = "User registration was successful , login to continue ";

		//unset seesions 
		unset($_SESSION['reg_fname']);
		unset($_SESSION['reg_lname']);
		unset($_SESSION['reg_email']);
		unset($_SESSION['reg_email2']);


	}
}
?>