<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="JSF tutorials">
		<meta name="keywords" content="sign up, jsf sign in, login">
		<meta name="author" content="shravya">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>JSF Tutorial</title>
		<style>
			.error {color: #FF0000;}
		</style>
		<script>
      
			$(document).ready(function()  
				{    
				$("#calc").click(function()    
					{ 
					$discount_rates=array();
					$discount_rates['student']=20;
					$discount_rates['software_engineer']=15;
					$discount_rates['other']=10;  
					var total=1000;
					if($('input[name=qualification]:checked').val() == "student" )
						total=total-(total*$discount_rates['student']/100);
					if($('input[name=qualification]:checked').val() == "software_engineer" )
						total=total-(total*$discount_rates['software_engineer']/100);
					if($('input[name=qualification]:checked').val() == "other" )
						total=total-(total*$discount_rates['other']/100);
					$("#fee").val(total);
					});
				});
		</script>
	</head>

	<body>
		<?php
			require('db.php');
			// define variables and set to empty values
			$nameErr = $emailErr = $qualificationErr = $mobileErr = $courseErr = $passErr = "";
			$name = $email = $qualification = $mobile = $course = $password = "";
							
			
				if (empty($_POST['name'])) {
					$nameErr = "Name is required";
				} else {
					$name = test_input($_POST['name']);
					// check if name only contains letters and whitespace
					if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
						$nameErr = "Only letters and white space allowed"; 
					}
				}
 			if (empty($_POST['email'])) {
				$emailErr = "Email is required";
			} else {
				$email = test_input($_POST['email']);
				// check if e-mail address is well-formed
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$emailErr = "Invalid email format"; 
				}
			}
			if (empty($_POST['pass'])) {
				$passErr = "Password is required";
			} else {
				$password = test_input($_POST['pass']);
    
  }
			if (empty($_POST['mobile'])) {
				$mobile = "";
			} else {
				$mobile = test_input($_POST['mobile']);
				// check if name only contains letters and whitespace
				if (!preg_match("/^[ 0-9 ]*$/",$mobile)) {
					$mobileErr = "Only numbers allowed"; 
				}
			}
  			if (empty($_POST['qualification'])) {
				$qualificationErr = "qualification is required";
			} else {
				$qualification = test_input($_POST['qualification']);
			}
			if (empty($_POST['course'])) {
				$courseErr = "course is required";
			} else {
				$course = test_input($_POST['course']);
			}
			function test_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
			if(!isset($error))
			{

					# Title of the CSV
					$Content = "Name, Email, Mobile, Course, Qualification\n";

					//set the data of the CSV
					$Content .= "$name, $email, $mobile, $course, $qualification\n";

					# set the file name and create CSV file
					$FileName = "log_".date("Y_m_d").".csv";
					header('Content-Type: application/csv'); 
					header('Content-Disposition: attachment; filename="' . $FileName . '"'); 
					$file = fopen($FileName, "a");
					
					fwrite($file, $Content);
					fclose($file);
					echo $Content;
					exit();
			}
		
 
		// If form submitted, insert values into the database.

			$username = stripslashes($name);
			$username = mysql_real_escape_string($username);
			 $email = stripslashes($email);
			 $email = mysql_real_escape_string($email);
			 $password = stripslashes($password);
			 $password = mysql_real_escape_string($password);
			 $mobile = stripslashes($mobile);
			 $mobile = mysql_real_escape_string($mobile);
			 $query = "INSERT into `login` (name, password, email, mobile) VALUES ('$username', '".md5($password)."', '$email', '$mobile')";
			 $result = mysql_query($query);
			 if($result){
			 echo "<div class='form'><h3>You are registered successfully.</h3><br/>Click here to <a href='login.php'>Login</a></div>";
			 }
			 
			
	?>
	
		<h2>JSF Tutorial Sign Up</h2>
		<p><span class="error">* required field.</span></p>
		<form action="signup.php" method="post" >  
			First Name: 
					<input type="text" name="name"/>
					<span class="error">* <?php echo $nameErr;?></span>
					<br><br>
			E-mail: 
					<input type="text" name="email"/>
					<span class="error">* <?php echo $emailErr;?></span>
					<br><br>
			Password:
					<input type="password" name="pass" />
					<span class="error">* <?php echo $passErr;?></span>
					<br><br>
			Mobile: 
					<input type="text" name="mobile" >
					<span class="error"><?php echo $mobileErr;?></span>
					<br><br>
			Course:<br>
					<input type="radio" name="course" value="full" <?php if (isset($course) && $course=="full") echo "checked";?> Full Time<br>
					<input type="radio" name="course" value="part" <?php if (isset($course) && $course=="part") echo "checked";?> Part Time <br>
					<span class="error"> <?php echo $courseErr;?></span>
  					<br><br>
			Qualification:<br>
					<input type="radio" name="qualification" value="student" <?php if (isset($qualification) && $qualification=="student") echo "checked";?> Student<br>
					<input type="radio" name="qualification" value="software_engineer" <?php if (isset($qualification) && $qualification=="student") echo "checked";?> Software_Engineer<br>
					<input type="radio" name="qualification" value="other" <?php if (isset($qualification) && $qualification=="other") echo "checked";?> Other
					<span class="error"> <?php echo $qualificationErr;?></span>
					<br><br>
					
					<input type="submit" name="submit" value="Submit" style="height:50px; width:300px; font-size:25px; font-weight:bold;background-color:#b9cd6d;text-align:center;"> <br><br>
					<input type="button" id="calc" value="Calculate your fee" onclick="calc()" style="height:50px; width:300px; font-size:25px; font-weight:bold;background-color:#b9cd6d;text-align:center;"><br><br>
					Your fee would be :;<input type="text" id="fee" readonly>					
		</form>

	</body>
</html>