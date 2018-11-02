<?php
	require_once('includes/header.php');


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
			<input type="submit" class="btn btn-primary" data-toggle="modal" data-target="#post_form_modal" value="Post something"/>
			<?php
				if($loggedInUser != $username){
					?>
					 <div class="profile_info_bottom">
					 	<?php
							 $mutualFriends_arr = $logged_user_obj->getMutualFriends($username);
							 if(isset($mutualFriends_arr['count'])){
								$count = $mutualFriends_arr['count'];
								if($count ==1){
									echo $mutualFriends_arr['count']." Mutual Friend";
								}elseif($count > 1){
									echo $mutualFriends_arr['count']." Mutual Friends";
								}else{
									echo "No Mutual Friends";
								}
							 }
							 
						 ?>
					 </div>
					<?php
				}
			?>
		</div>
		
		<div class="profile_main_column column">
			<img src="assets/images/icons/loading.gif" id="loading"/>
			<div id="post_area">
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="post_form_modal" tabindex="-1" role="dialog" aria-labelledby="postModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="postModalLabel">Post something</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>This will appear on the user's profile page and also their newsfeed for your friends to see ! </p>

						<form class="profile_post form" action="" method="POST">
							<div class="form-group">
								<textarea class="form-control" name="post_body" id="" cols="60" rows="3"></textarea>
								<input type="hidden" name="user_from" value="<?php echo $loggedInUser;?>"/>
								<input type="hidden" name="user_to" value="<?php echo $username;?>"/>

							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary" name="post_button" id="submit_profile_post">Post</button>
					</div>
				</div>
			</div>
		</div><!-- modal ends -->

		<script type="text/javascript"> 
			 var userLoggedIn ='<?php echo $loggedInUser; ?>';
			 var profileUsername='<?php echo $username;?>';
			 $(document).ready(function(){
				 $('#loading').show();
				 //original ajax request
				 $.ajax({
					 url:"includes/handlers/ajax_load_profile_posts.php",
					 type:"POST",
					 data:{'page':1,'userLoggedIn':userLoggedIn,'profileUsername':profileUsername},
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
						url:"includes/handlers/ajax_load_profile_posts.php",
						type:"POST",
						data:{'page':page,'userLoggedIn':userLoggedIn,'profileUsername':profileUsername},
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
