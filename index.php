<?php
	require_once 'includes/header.php';
	// require_once 'includes/classes/User.php';
	// require_once 'includes/classes/Post.php';

	if(isset($_POST['post'])){
		$post = new Post($conn,$loggedInUser);
		$post->submitPost($_POST['post_text'],'none');
		header('Location:index.php');
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
					$friends_str = ltrim($userRow['friend_array'],",");
					$friends_str = rtrim($friends_str,",");
					$friends = explode(",",$friends_str);
					echo "Friends: ".count($friends);

				?>
			</div>
		</div>
		<div class="main_column column">
			<form action="index.php" class="post_form" method="post">
				<textarea name="post_text" id="post_text" placeholder="Got something to say ?"></textarea>
				<input type="submit" name="post" id="post_button" value="post">
				<hr>
			</form>
			<img src="assets/images/icons/loading.gif" id="loading"/>

			<div id="post_area">
			</div>
			
		</div>
		<script type="text/javascript"> 
			 var userLoggedIn ='<?php echo $loggedInUser; ?>';
			 $(document).ready(function(){
				 $('#loading').show();
				 //original ajax request
				 $.ajax({
					 url:"includes/handlers/ajax_load_posts.php",
					 type:"POST",
					 data:{'page':1,'userLoggedIn':userLoggedIn},
					 cache:false,
					 success:function(data){
						$('#loading').hide();
						$("#post_area").append(data);
					 }
					
				 });
				$(window).scroll(function(){
				 	var height = $("#post_area").height(); //div containing posts
				 	var scroll_top =$(this).scrollTop();
				 	var page =$('#post_area').find('.nextPage').val();
				 	var noMorePosts =	$("#post_area").find('.noMorePosts').val();					
					if((document.body.scrollHeight == (scroll_top + window.innerHeight)) && noMorePosts =='false'){
						$('#loading').show();
						var ajaxReg =$.ajax({
						url:"includes/handlers/ajax_load_posts.php",
						type:"POST",
						data:{'page':page,'userLoggedIn':userLoggedIn},
						cache:false,
							success:function(response){
								$('#post_area').find('.nextPage').remove();
								$("#post_area").find('.noMorePosts').remove();

								$('#loading').hide();
								$("#post_area").append(response);
							}					
						});
					} //End if
					return false;
				}); //End (window).scroll(function())

			 });
			 
		
		</script>

	</div><!-- wrapper -->
</body>
</html>
