<?php 

session_start();

	include("classes/connect.php");
	include("classes/login.php");
 
	$email = "";
	$password = "";
	$email_err = "";
	$password_err = "";
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{


		$login = new Login();
		$result = $login->evaluate($_POST);
		
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);

		if(empty(trim($_POST["password"]))){
			$password_err = "Please enter a password.";
		}
		if(empty(trim($_POST["email"]))){
			$email_err = "Please enter an email.";
		}
		
		if($result=="" && $password_err=="" && $email_err=="")
		{

			header("Location:" .ROOT. "profile");
			die;
		}

	}


	

?>

<html> 

	<head>
		
		<title>Log in</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	</head>

	<style>

		#text{

			height: 40px;
			width: 300px;
			border-radius: 10px;
			padding: 4px;
			font-size: 14px;
		}

		

		
		body{
  background-color: #3399ff;
}


.circle{
  position: absolute;
  border-radius: 50%;
  background: white;
  animation: ripple 15s infinite;
  box-shadow: 0px 0px 1px 0px #508fb9;
}

.small{
  width: 200px;
  height: 200px;
  left: 0px;
  top: 0px;
}

.medium{
  width: 400px;
  height: 400px;
  left: 100px;
  top: 100px;
}

.large{
  width: 600px;
  height: 600px;
  left: -300px;
  bottom: 300px;
}

.xlarge{
  width: 800px;
  height: 800px;
  left: -400px;
  bottom: 200px;
}

.xxlarge{
  width: 1000px;
  height: 1000px;
  left: -500px;
  bottom: 100px;
}

.shade1{
  opacity: 0.2;
}
.shade2{
  opacity: 0.5;
}

.shade3{
  opacity: 0.7;
}

.shade4{
  opacity: 0.8;
}

.shade5{
  opacity: 0.9;
}

@keyframes ripple{
  0%{
    transform: scale(0.9);
  }
  
  50%{
    transform: scale(1.2);
  }
  
  100%{
    transform: scale(0.9);
  }
}

.wrapper{
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

	<body style="font-family: tahoma;color:black;">
	<div class='ripple-background'>
  <div class='circle xxlarge shade1'></div>
  <div class='circle xlarge shade2'></div>
  <div class='circle large shade3'></div>
  <div class='circle mediun shade4'></div>
  
  <div class='circle small shade5'>
  <h4 style="font-family:Comic Sans MS;font-weight:bold;position:absolute; top:120px; left:38px;">WELCOME</h4>
  </div>
  
</div><br><br>


<div class="wrapper">
			<center><img src="donartLogo.png" style="position:absolute; display:inline;left:80px; top:8px; height:50px;width:45px;">
			<h1 style="font-family:Tahoma; display:inline;font-weight:bold; color:black;text-align:left;">Donart</h1>
			
			<?php if(!empty($result) && empty($email_err) && empty($password_err))
			{echo "<div class='alert alert-danger'>".$result."</div>";} ?>
				<form method="post">
					
					<div class="form-group">
					
						<input name="email" value="<?php echo $email ?>" class="form-control <?php 
                        echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" type="text" id="text" placeholder="Email">
					
					<span class="invalid-feedback">
                        <?php echo $email_err; ?>
                    </span>
					</div>
					<div class="form-group">
					
						<input name="password" value="<?php echo $password ?>" class="form-control <?php 
                        echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" type="password" id="text" placeholder="Password">
					
					<span class="invalid-feedback">
                        <?php echo $password_err; ?>
                    </span>
					</div>
					<div class="form-group">
						<input type="submit" class="btn btn-primary" style="float:right;" value="Log in">
						
					</div>
					<br><br>
					<p style="color:black;">Don't have an account? <a href="signup.php" style="font-weight:bold;">Sign Up </a> </p>
				</form>
			</center>	
			
		</div>
<br>
		<img style="position:absolute;top:0px;height=100px;width:200px;" src="s1.png">

	</body>


</html>