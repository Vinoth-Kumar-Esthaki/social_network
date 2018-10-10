<?php
	require_once('includes/header.php');
	require_once 'includes/classes/User.php';
	require_once 'includes/classes/Post.php';


	if(isset($_GET['profile_username'])){
		$username = $_GET['profile_username'];
		$user_details_query = mysqli_query($conn,"SELECT * FROM `user` WHERE username='$username'");
		$user_array = mysqli_fetch_array($user_details_query);

		$num_friends = (substr_count($user_array['friend_array'],","))-1;

	}

	if(isset($_POST['remove_friend'])){
		$user = new User($conn,$loggedInUser);
		$user->removeFriend($username);
	}

	if(isset($_POST['add_friend'])){
		$user = new User($conn,$loggedInUser);
		$user->sendFriendRequest($username);
	}

	if(isset($_POST['respond_request'])){
		header('Location:request.php');
	}
?>	
		<style>
			* { padding: 0; margin: 0; }
			html, body, .profile_left {
				min-height: 100% !important;
				height: 100%;
			}
			.wrapper{
				margin-left:0;
				padding-left:0;
			}
		</style>
		<div class="profile_left">
			<img src="<?php echo $user_array['profile_pic'];?>" alt="profile_pic"/>
			<div class="profile_name">
				<h4>
					<?php echo $user_array['first_name']." ". $user_array['last_name'];?>
				</h4>
			</div>
			<div class="profile_info">
				<p> Posts: <?php echo $user_array['num_posts'];?></p>
				<p> Likes: <?php echo $user_array['num_likes'];?></p>
				<p> Friends: <?php echo $num_friends;?></p>
			</div>
			<form action="<?php echo $username;?>" class="form" method="POST">
				<?php
					$profile_user_obj = new User($conn,$username);
					if($profile_user_obj->isClosed()){
						header("Location:user_closed.php");
					}
					$logged_user_obj = new User($conn,$loggedInUser);
					if($loggedInUser != $username){
						if($logged_user_obj->isFriend($username)){
							echo "<input type='submit' name='remove_friend' class='btn btn-danger' value='Remove Friend'>"."<br>";
						}elseif($logged_user_obj->didReceivedFriendRequest($username)){
							echo "<input type='submit' name='respond_request' class='btn btn-warning' value='Respond to Request'>"."<br>";
						}elseif($logged_user_obj->didSendFriendRequest($username)){
							echo "<input type='submit' name='' class='btn btn-default' value='Request Sent'>"."<br>";
						}else{
							echo "<input type='submit' name='add_friend' class='btn btn-success' value='Add Friend'>"."<br>";

						}
						
					}
				?>
			</form>
		</div>
		
		<div class="main_column column">
			<?php echo $username;?>
		</div>

	</div><!-- wrapper -->
</body>
</html>
