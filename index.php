<?php
	require_once 'includes/header.php';
	require_once 'includes/classes/User.php';
	require_once 'includes/classes/Post.php';

	if(isset($_POST['post'])){
		$post = new Post($conn,$loggedInUser);
		$post->submitPost($_POST['post_text'],'none');
	}
?>
		<div class="user_details column">
			<!-- user pic -->
			<a href="<?php echo $loggedInUser;?>">
				<img src="<?php echo $userRow['profile_pic'];?>" alt="user image">
				
			</a>
			<div class="user_details_left_right">
				<!-- username -->
				<a href="<?php echo $loggedInUser;?>">
				<?php
					echo $userRow['first_name']." ".$userRow['last_name'];
				?>
				</a>
				<br>
				<?php 
					echo "Posts: ".$userRow['num_posts']."<br>";
					echo "Likes: ".$userRow['num_likes']."<br>";
				?>
			</div>
		</div>
		<div class="main_column column">
			<form action="index.php" class="post_form" method="post">
				<textarea name="post_text" id="post_text" placeholder="Got something to say ?"></textarea>
				<input type="submit" name="post" id="post_button" value="post">
				<hr>
			</form>
			<?php
				$user = new User($conn,$loggedInUser);
				echo $user->getFirstAndLastName();
			?>
		</div>

	</div><!-- wrapper -->
</body>
</html>
