<?php
require_once 'config/config.php';
require_once 'includes/form_handlers/register_handler.php';
require_once 'includes/form_handlers/login_handler.php';


?>
<!DOCTYPE html>
<html>
<head>
	<title>Welcome to social network</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
</head>
<body>
	<div class="wrapper">
		<div class="login_box">
			<form action="register.php" method="POST">
				<input type="text" name="log_email" placeholder="Email address" required="true" value="<?php 
					if(isset($_SESSION['log_name'])){echo $_SESSION['log_name'];} ?>" />
				<br/>
				<input type="password" name="log_password" placeholder="Password" required="true" />
				<br>
				<input type="submit" name="login_button" value ="login">
				<?php
					if(isset($error_array['log_failed'])){
						echo $error_array['log_failed'];
					}
				?>
			</form>
			<form action="register.php" method="post">
				
				<input type="text" name="reg_fname" placeholder="First name" required="true" 
					value="<?php if(isset($_SESSION['reg_fname'])){echo $_SESSION['reg_fname'];} ?>"/>

					<?php
						if(isset($error_array['f_invalid'])){
							echo  $error_array['f_invalid'];
						}
					?>
				<br>
				<input type="text" name="reg_lname" placeholder="Last name" required="true"
				value="<?php if(isset($_SESSION['reg_lname'])){echo $_SESSION['reg_lname'];} ?>"
				/>			
				<br>
					<?php
						if(isset($error_array['l_invalid'])){
							echo  $error_array['l_invalid'];
						}
					?>
				<input type="email" name="reg_email" placeholder="Email" required="true"
				value="<?php if(isset($_SESSION['reg_email'])){echo $_SESSION['reg_email'];} ?>"
				/>			
				<br>
				<input type="email" name="reg_email2" placeholder="Confirm Email" required="true"
				value="<?php if(isset($_SESSION['reg_email2'])){echo $_SESSION['reg_email2'];} ?>"
				/>
				<br>
					<?php
						if(isset($error_array['e_exist'])){
							echo  $error_array['e_exist'];
						}elseif(isset($error_array['e_invalid'])){
							echo $error_array['e_invalid'];
						}elseif(isset($error_array['e_match'])){
							echo $error_array['e_match'];
						}
					?>
				<input type="password" name="reg_password" placeholder="Password" required="true">
				<br>
				<input type="password" name="reg_password2" placeholder="Confirm Password" required="true">
				<br>
				<?php
					if(isset($error_array['p_invalid'])){
						echo $error_array['p_invalid'];
					}elseif(isset($error_array['p_match'])){
						echo $error_array['p_match'];
					}elseif(isset($error_array['p_format'])){
						echo $error_array['p_format'];
					}
				?>
				<input type="submit" name="register_button" value="Sign Up"/>
			</form>
			<?php
				if(isset($success_array['success'])){
					echo $success_array['success'];
				}
			?>
		</div>
	</div>
</body>
</html>