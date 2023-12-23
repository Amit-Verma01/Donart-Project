<!--top bar-->
<?php 

	$corner_image = "images/user_male.jpg";
	if(isset($USER)){
		
		if(file_exists($USER['profile_image']))
		{
			$image_class = new Image();
			$corner_image = $image_class->get_thumb_profile($USER['profile_image']);
		}else{

			if($USER['gender'] == "Female"){

				$corner_image = "images/user_female.jpg";
			}
		}
	}
?>

<div id="blue_bar">
	<form method="get" action="<?=ROOT?>search">
		<div style=" width: 800px;margin:auto;font-size: 15px; padding-bottom:2px;">
		<img src="donartLogo.png" style="position:absolute; display:inline;left:238px; top:19px; height:50px;width:45px;">
			<a href="<?=ROOT?>home" style="color:#EDEAE5; text-decoration:none; font-weight:bold;"><h1 style="color:#000000;display:inline; font-family:tahoma;">Donart</h1></a> 
			&nbsp &nbsp <input type="text" id="search_box" name="find" placeholder="Search for people" />

			<?php if(isset($USER)): ?>
				<a href="<?=ROOT?>profile">
				<img src="<?php echo ROOT . $corner_image ?>" style="width: 50px; border-radius:100px;float: right;">
				</a>
				<a href="<?=ROOT?>logout">
				<span style="font-weight:bold;font-size:15px;float: right;margin:10px;color:##B2BEB5;">Logout</span>
				</a>

				&nbsp<a href="<?=ROOT?>notifications">
				<span style="display: inline-block;position: relative;">
					<img src="<?=ROOT?>not.png" style="width:22px; height:22px;float:right;margin-top: 10px">
					<?php 
						$notif = check_notifications();
					?>
					<?php if($notif > 0): ?>
						<div style="background-color: red;color: white;position: absolute;right:-15px;
						width:15px;height: 15px;border-radius: 50%;padding: 4px;text-align:center;font-size: 14px;"><?= $notif ?></div>
					<?php endif; ?>
				</span>
				</a>

				<a href="<?=ROOT?>messages">
				<span style="display: inline-block;position: relative;margin-left: 10px;">
 					<svg fill="#899499" style="float:right;margin-top: 10px; " width="25" height="25"  viewBox="0 0 24 24"><path d="M12 12.713l-11.985-9.713h23.971l-11.986 9.713zm-5.425-1.822l-6.575-5.329v12.501l6.575-7.172zm10.85 0l6.575 7.172v-12.501l-6.575 5.329zm-1.557 1.261l-3.868 3.135-3.868-3.135-8.11 8.848h23.956l-8.11-8.848z"/></svg>
					<?php 
						$notif = check_messages();
					?>
					<?php if($notif > 0): ?>
						<div style="background-color: red;color: white;position: absolute;right:-15px;
						width:15px;height: 15px;border-radius: 50%;padding: 4px;text-align:center;font-size: 14px;"><?= $notif ?></div>
					<?php endif; ?>
				</span>
				</a>

				

			<?php else: ?>
				<a href="<?=ROOT?>login">
				<span style="font-size:13px;float: right;margin:10px;color:white;">Login</span>
				</a>
			<?php endif; ?>


		</div>
	</form>
</div>
<br>