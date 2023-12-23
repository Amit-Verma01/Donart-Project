<?php 

class Signup
{

	private $first_name_err ="";
	private $last_name_err ="";
	private $password_err ="";
	private $confirm_err =""; 
	private $email_err = "";
	private $gender_err = "";

	//function for checking errors
	public function evaluate($data)
	{

		foreach ($data as $key => $value) {

			//checking name error
			if($key == "first_name" && !empty($value))
			{
				if (is_numeric($value)) {
        
 					$this->first_name_err = $this->first_name_err . "first name cant be a number<br>";
    			}

    			if (strstr($value, " ")) {
        
 					$this->first_name_err = $this->first_name_err . "first name cant have spaces<br>";
    			}
 
			}else if($key == "first_name" && empty($value)){ $this->first_name_err = "Please enter your First name<br>";}

			if($key == "last_name" && !empty($value))
			{
				if (is_numeric($value)) {
        
 					$this->last_name_err = $this->last_name_err . "last name cant be a number<br>";
    			}

    			if (strstr($value, " ")) {
        
 					$this->last_name_err = $this->last_name_err . "last name cant have spaces<br>";
    			}

			}else if($key == "last_name" && empty($value)){ $this->last_name_err = "Please enter your last name<br>";}

			//checking email error
			if($key == "email" && !empty($value))
			{
				if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$value)) {
        
 					$this->email_err = $this->email_err . "invalid email address<br>";
    			}
			}else if($key == "email" && empty($value)){ $this->email_err = "Please enter your email<br>";}

			//checking password error
			if($key == "password" && !empty($value)){
				if(strlen($value) < 6){
					$this->password_err .= "Password must have atleast 6 characters.";
				}
			}else if($key == "password" && empty($value)){$this->password_err = "Please enter a Password<br>";}
			
			//checking confirm password error
			if($key == "password2" && !empty($value)){
				if(empty($this->password_err) && ($data['password'] != $data['password2'])){
					$this->confirm_err .= "Password didn't match";
				}
			}else if($key == "password2" && empty($value)){ $this->confirm_err ="Please confirm the password<br>";}
  
			//checking gender error
			if($key == "gender" && empty($value)){ $this->gender_err = "Please select your gender<br>";}
			
		}

		$DB = new Database();

		//check tag name
		$data['tag_name'] = strtolower($data['first_name'] . $data['last_name']);

		$sql = "select id from users where tag_name = '$data[tag_name]' limit 1";
		$check = $DB->read($sql);
		while(is_array($check)){

			$data['tag_name'] = strtolower($data['first_name'] . $data['last_name']) . rand(0,9999);
			$sql = "select id from users where tag_name = '$data[tag_name]' limit 1";
			$check = $DB->read($sql);
		}

		$data['userid'] = $this->create_userid();
		//check userid
		$sql = "select id from users where userid = '$data[userid]' limit 1";
		$check = $DB->read($sql);
		while(is_array($check)){

			$data['userid'] = $this->create_userid();
			$sql = "select id from users where userid = '$data[userid]' limit 1";
			$check = $DB->read($sql);
		}

		//check email
		$sql = "select id from users where email = '$data[email]' limit 1";
		$check = $DB->read($sql);
		if(is_array($check)){

			 $this->email_err = $this->email_err . "Another user is already using that email<br>";
		}
 
		$error['first_name_err']= $this->first_name_err;
		$error['last_name_err']= $this->last_name_err;
		$error['password_err']= $this->password_err;
		$error['confirm_err']= $this->confirm_err;
		$error['email_err']= $this->email_err;
		$error['gender_err']=$this->gender_err;

		if(empty($this->gender_err) && empty($this->first_name_err) && empty($this->last_name_err) && empty($this->password_err) && empty($this->confirm_err) && empty($this->email_err))
		{

			//no error
			$this->create_user($data);
		}else
		{
			return $error;
		}
	}

	public function create_user($data)
	{

		$first_name = ucfirst($data['first_name']);
		$last_name = ucfirst($data['last_name']);
		$gender = $data['gender'];
		$email = $data['email'];
		$password = $data['password'];
		$userid = $data['userid'];
		$tag_name = $data['tag_name'];
		$date = date("Y-m-d H:i:s");
		$type = "profile";

		$password = hash("sha1", $password);
		
		//create these
		$url_address = strtolower($first_name) . "." . strtolower($last_name);

		$query = "insert into users 
		(type,userid,first_name,last_name,gender,email,password,url_address,tag_name,date) 
		values 
		('$type','$userid','$first_name','$last_name','$gender','$email','$password','$url_address','$tag_name','$date')";


		$DB = new Database();
		$DB->save($query); 
	}
 
	private function create_userid()
	{

		$length = rand(4,19);
		$number = "";
		for ($i=0; $i < $length; $i++) { 
			# code...
			$new_rand = rand(0,9);

			$number = $number . $new_rand;
		}

		return $number;
	}
}