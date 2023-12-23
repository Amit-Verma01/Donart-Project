<?php 

	include("classes/connect.php");
	include("classes/signup.php");

	$first_name = "";
	$last_name = "";
	$gender = "";
	$email = "";
	$password = "";
	$confirm_password = "";

	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{


		$signup = new Signup();
		$result = $signup->evaluate($_POST);
		if(empty($result)){
			header("Location:login.php");
				die; 
		}
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$gender = $_POST['gender'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirm_password = $_POST['password2'];

	}


	

?>

<html> 

	<head>
		
		<title>Signup</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	</head>

	<style>	
		#text{
			width: 300px;
			font-size: 14px;
		}

		.wrapper{
			width: 400px; 
            padding: 10px;
            box-shadow: 1px 1px 5px #888888;
            background-color: #FFFFFF;
			margin:auto;
			text-align:center;
			padding:10px;
			padding-top: 30px;

			margin:auto;
			top:0px;
			left:500px;
			border-radius:0px 400px 0px 400px;
			width: 360px; 
			padding: 20px;
			box-shadow: 0px 0px 20px #36454F;
			position:absolute;
			background-image:linear-gradient(to right,#efc4cb,#e77586,#ffc0cb,#fbb8c2);
		}

	</style>

	<body style="font-family: sans-serif;background-image:url('images/xyz.jpg');">

		<div class="wrapper">
			<center>
			<img src="donartLogo.png" style="position:absolute; display:inline;left:80px; top:8px; height:50px;width:45px;">
			<h1 style="font-family:Tahoma; display:inline;font-weight:bold; color:black;text-align:left;">Donart</h1>
				<p style="color:grey;">Sign up because your choice matters</p>

				<form method="post" action="">
					<div class="form-group">
						<input value="<?php echo $first_name ?>" name="first_name" class="form-control <?php 
                        echo (!empty($result['first_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php 
                        echo $first_name; ?>" type="text" id="text" placeholder="First name">

						<span class="invalid-feedback">
                        <?php echo $result['first_name_err']; ?>
                    </span>
					</div>
					<div class="form-group">
						<input value="<?php echo $last_name ?>" name="last_name" class="form-control <?php 
                        echo (!empty($result['last_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php 
                        echo $last_name; ?>" type="text" id="text" placeholder="Last name">

						<span class="invalid-feedback">
                        <?php echo $result['last_name_err']; ?>
                    </span>
					</div>
					<div class="form-group">
						
						<select style="color:grey;" id="text" class="form-control <?php 
                        echo (!empty($result['gender_err'])) ? 'is-invalid' : ''; ?>" value="<?php 
                        echo $gender; ?>" name="gender">
						    <option value="" hidden>Gender</option>
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>

							<span class="invalid-feedback">
                        		<?php echo $result['gender_err']; ?>
                    		</span>
					</div>
						
					<div class="form-group">
						<input value="<?php echo $email ?>" name="email" class="form-control <?php 
                        echo (!empty($result['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php 
                        echo $email; ?>" type="text" id="text" placeholder="Email">

						<span class="invalid-feedback">
                        <?php echo $result['email_err']; ?>
                    </span>
					</div>
					<div class="form-group">
						<input name="password" class="form-control <?php 
                        echo (!empty($result['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php 
                        echo $password; ?>" type="password" id="text" placeholder="Password">

					<span class="invalid-feedback">
                        <?php echo $result['password_err']; ?>
                    </span>
					</div>
					<div class="form-group">
						<input name="password2" class="form-control <?php 
                        echo (!empty($result['confirm_err'])) ? 'is-invalid' : ''; ?>" value="<?php 
                        echo $confirm_password; ?>" type="password" id="text" placeholder="Retype Password">

					<span class="invalid-feedback">
                        <?php echo $result['confirm_err']; ?>
                    </span>
					</div>
					<div class="form-group">
						<input class="btn btn-primary" type="submit" value="Sign up">
						
					</div>
					<p style="color:white; text-shadow:1px 1px 5px black;font-weight:bold;display:inline;">Already have an account?</p> <a href="login.php" style="display:inline; font-weight:bold;">Log in</a>
				</form>
			</center>
		</div>

	</body>


</html>