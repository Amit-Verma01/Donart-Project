<?php

	include("classes/autoload.php");
	

	$login = new Login();
	$_SESSION['mybook_userid'] = isset($_SESSION['mybook_userid']) ? $_SESSION['mybook_userid'] : 0;
	
	$user_data = $login->check_login($_SESSION['mybook_userid'],false);
 
 	$USER = $user_data;
 	
 	if(isset($URL[1]) && is_numeric($URL[1])){

	 	$profile = new Profile();
	 	$profile_data = $profile->get_profile($URL[1]);

	 	if(is_array($profile_data)){
	 		$user_data = $profile_data[0];
	 	}

 	}
 	
	//posting starts here
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{

		include("change_image.php");
		
		if(isset($_POST['first_name'])){

			$settings_class = new Settings();
			$settings_class->save_settings($_POST,$_SESSION['mybook_userid']);

		}elseif(isset($_POST['post'])){

			$post = new Post();
			$id = $_SESSION['mybook_userid'];
			$result = $post->create_post($id, $_POST,$_FILES);
			
			if($result == "")
			{
				header("Location: profile.php");
				die;
			}else
			{

				echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
				echo "<br>The following errors occured:<br><br>";
				echo $result;
				echo "</div>";
			}
		}
			
	}

	//collect posts
	$post = new Post();
	$id = $user_data['userid'];
	
	$posts = $post->get_posts($id);

	//collect friends
	$user = new User();
 	
	$friends = $user->get_following($user_data['userid'],"user");

	$image_class = new Image();

	//check if this is from a notification
	if(isset($URL[2])){
		notification_seen($URL[2]);
	}

?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Profile</title>
		
	</head>

	<style type="text/css">
		
		#blue_bar{

			height: 50px;
			color: #d9dfeb;
			font-family: sans-serif;
			background-color:#FFFFFF;
			box-shadow: 0px 1px 0px #D3D3D3;

		}

		#search_box{

			width: 400px;
			height: 20px;
			border-radius: 5px;
			border:none;
			padding: 4px;
			font-size: 14px;
			background-image: url(search.png);
			background-repeat: no-repeat;
			background-position: right;
			border:1px solid #D3D3D3;

		}

		#textbox{

			width: 100%;
			height: 20px;
			border-radius: 5px;
			border:none;
			padding: 4px;
			font-size: 14px;
			border: solid thin #EDEADE;
			margin:10px;
 
		}

		#profile_pic{

			width: 150px;
			margin-top: -300px;
			border-radius: 50%;
			border:solid 2px white;
		}

		#menu_buttons{

			width: 100px;
			display: inline-block;
			margin:2px solid grey;
			color:#36454F;
			font-weight: bold;
			border-radius: 5px;
		}

		body{
			font-family: Comic Sans MS;
			background-color:#FFFFFF;

		}

		#friends_img{

			width: 75px;
			float: left;
			margin:8px;

		}

		#friends_bar{

			background-color: #EDEADE;
			min-height: 400px;
			margin-top: 20px;
			color: #aaa;
			padding: 8px;
		}

		#friends{

		 	clear: both;
		 	font-size: 12px;
		 	font-weight: bold;
		 	color: #405d9b;
		}

		textarea{

			width: 100%;
			border:none;
			font-family: tahoma;
			font-size: 14px;
			height: 60px;

		}

		#post_button{

			float: right;
			background-color: #3399ff;
			border:thin solid #EDEADE;
			font-weight:bold;
			color: #FFFFFF;
			padding: 4px;
			font-size: 13px;
			border-radius: 5px;
			width: 50px;
			min-width: 50px;
			cursor: pointer;
		}
 
 		#post_bar{

 			margin-top: 20px;
 			background-color: #EDEADE;
 			padding: 10px;
 		}

 		#post{

 			padding: 4px;
 			font-size: 13px;
 			display: flex;
 			margin-bottom: 20px;
			 background-color:#EDEADE
 		}

	</style>

	<body>

		<br>
		<?php include("header.php"); ?>
 
 		<!--change profile image area-->
 		<div id="change_profile_image" style="display:none;position:absolute;width: 100%;height: 100%;background-color: #FFFFFF;">
 			<div style="max-width:600px;margin:auto;min-height: 400px;flex:2.5;padding: 20px;padding-right: 0px;">
 					
 					<form method="post" action="<?=ROOT?>profile/profile" enctype="multipart/form-data">
	 					<div style="border:solid thin #aaa; padding: 10px;background-color: white;">

	 						<input type="file" name="file"><br>
	 						<input id="post_button" type="submit" style="width:120px;" value="Change">
	 						<br>
							<div style="text-align: center;">
								<br><br>
							<?php

								echo "<img src='" . ROOT . "$user_data[profile_image]' style='max-width:500px;' >";
  
	 						?>
							</div>
	 					</div>
  					</form>

 				</div>
 		</div>
		
		<!--change cover image area-->
 		<div id="change_cover_image" style="display:none;position:absolute;width: 100%;height: 100%;background-color: 000088;">
 			<div style="max-width:600px;margin:auto;min-height: 400px;flex:2.5;padding: 20px;padding-right: 0px;">
 					
 					<form method="post" action="<?=ROOT?>profile/cover" enctype="multipart/form-data">
	 					<div style="border:solid thin #aaa; padding: 10px;background-color: white;">

	 						<input type="file" name="file"><br>
	 						<input id="post_button" type="submit" style="width:120px;" value="Change">
	 						<br>
							<div style="text-align: center;">
								<br><br>
							<?php

 	 							echo "<img src='" . ROOT . "$user_data[cover_image]' style='max-width:500px;' >";
								 
	 						?>
							</div>
	 					</div>
  					</form>

 				</div>
 		</div>

		<!--cover area-->
		<div style="width: 800px;margin:auto;min-height: 400px;">
			
			<div style="background-color: #FCE181; background-image: linear-gradient(to right,#FFFFFF,#ade6e6,#FFFFFF);text-align: center;color: #405d9b; padding-bottom:5px;">

					<?php 

						$image = "images/cover_image.jpg";
						if(file_exists($user_data['cover_image']))
						{
							$image = $image_class->get_thumb_cover($user_data['cover_image']);
						}
					?>

				<img src="<?php echo ROOT . $image ?>" style="width:100%;">


				<span style="font-size: 12px;">
					<?php 

						$image = "images/user_male.jpg";
						if($user_data['gender'] == "Female")
						{
							$image = "images/user_female.jpg";
						}
						if(file_exists($user_data['profile_image']))
						{
							$image = $image_class->get_thumb_profile($user_data['profile_image']);
						}
					?>

					<img id="profile_pic" src="<?php echo ROOT . $image ?>"><br/>

					<?php if(i_own_content($user_data)):?>
					
						<a onclick="show_change_profile_image(event)" style="text-decoration: none;color:#A9A9A9;" href="<?=ROOT?>change_profile_image/profile">Change Profile Image</a> | 
						<a onclick="show_change_cover_image(event)" style="text-decoration: none;color:#A9A9A9;" href="<?=ROOT?>change_profile_image/cover">Change Cover</a>
					
					<?php endif; ?>

				</span>
				<br>
					<div style="font-size: 20px;color: black; background-color: #FCE181;background-image: linear-gradient(to right,#FFFFFF,#efc4cb,#FFFFFF,#FFFFFF,#efc4cb,#FFFFFF);">
						<a style="text-decoration:none; color:#36454F; font-weight:bold;" href="<?=ROOT?>profile/<?php echo $user_data['userid'] ?>">
							<?php echo $user_data['first_name'] . " " . $user_data['last_name']  ?>
							<br><span style="font-size:12px;">@<?=$user_data['tag_name']?></span>
						</a>

						<?php 
							$mylikes = "";
							if($user_data['likes'] > 0){

								$mylikes = "(" . $user_data['likes'] . " Followers)";
							}
						?>
						<br>

						<a href="<?=ROOT?>like/user/<?php echo $user_data['userid'] ?>">
							<input id="post_button" type="button" value="Follow <?php echo $mylikes ?>" style="color:#FFFFFF; margin-right:10px;background-color: #3399ff;width:auto;">
						</a>

						<?php if($user_data['userid'] == $_SESSION['mybook_userid']): ?>
							<a href="<?=ROOT?>messages">
								<input id="post_button" type="button" value="Messages" style="color:#FFFFFF;margin-right:10px;background-color: #3399ff;width:auto;">
							</a>
						<?php else: ?>
							<a href="<?=ROOT?>messages/new/<?=$user_data['userid']?>">
								<input id="post_button" type="button" value="Message" style="margin-right:10px;background-color: #1b9186;width:auto;">
							</a>
						<?php endif; ?>
 						

					</div>
				<br>
				<br>


				<a href="<?=ROOT?>home"><div id="menu_buttons" style="border:thin solid #EDEADE;">Timeline</div></a>&nbsp
				<a href="<?=ROOT?>profile/<?php echo $user_data['userid'] ?>/about"><div id="menu_buttons" style="border:thin solid #EDEADE;">About</div></a>&nbsp
				<a href="<?=ROOT?>profile/<?php echo $user_data['userid'] ?>/followers"><div id="menu_buttons" style="border:thin solid #EDEADE;">Followers</div></a>&nbsp
				<a href="<?=ROOT?>profile/<?php echo $user_data['userid'] ?>/following"><div id="menu_buttons" style="border:thin solid #EDEADE;">Following</div></a>&nbsp
				<a href="<?=ROOT?>profile/<?php echo $user_data['userid'] ?>/photos"><div id="menu_buttons" style="border:thin solid #EDEADE;">Photos</div></a>&nbsp
				
				<?php 
					if($user_data['userid'] == $_SESSION['mybook_userid']){
						
						echo '<a href="'.ROOT. 'profile/'.$user_data['userid'].'/groups"><div id="menu_buttons" style="border:thin solid #EDEADE;">Groups</div></a>&nbsp&nbsp';
						echo '<a href="'.ROOT. 'profile/'.$user_data['userid'].'/settings"><div id="menu_buttons" style="border:thin solid #EDEADE;">Settings</div></a>&nbsp&nbsp';
					}
				?>
			</div>

			<!--below cover area-->
	 
	 		<?php 

	 			$section = "default";

	 			if(isset($URL[2])){

	 				$section = $URL[2];
	 			}

	 			if($section == "default"){

	 				include("profile_content_default.php");
	 			 
	 			}elseif($section == "following"){
	 				
	 				include("profile_content_following.php");

	 			}elseif($section == "followers"){

	 				include("profile_content_followers.php");

	 			}elseif($section == "about"){

	 				include("profile_content_about.php");

	 			}elseif($section == "settings"){

	 				include("profile_content_settings.php");

	 			}elseif($section == "photos"){

	 				include("profile_content_photos.php");
	 			}elseif($section == "groups"){

	 				include("profile_content_groups.php");
	 			}



	 		?>

		</div>

	</body>
</html>

<script type="text/javascript">
	
	function show_change_profile_image(event){

		event.preventDefault();
		var profile_image = document.getElementById("change_profile_image");
		profile_image.style.display = "block";
	}


	function hide_change_profile_image(){

		var profile_image = document.getElementById("change_profile_image");
		profile_image.style.display = "none";
	}

	
	function show_change_cover_image(event){

		event.preventDefault();
		var cover_image = document.getElementById("change_cover_image");
		cover_image.style.display = "block";
	}


	function hide_change_cover_image(){

		var cover_image = document.getElementById("change_cover_image");
		cover_image.style.display = "none";
	}


	window.onkeydown = function(key){

		if(key.keyCode == 27){

			//esc key was pressed
			hide_change_profile_image();
			hide_change_cover_image();
		}
	}

	
</script>