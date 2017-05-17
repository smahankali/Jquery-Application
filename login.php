<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
		<meta name="description" content="JSF login">
		<meta name="keywords" content="login, password, username">
		<meta name="author" content="shravya">
		<title>JSF Tutorial</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Login</title>
		<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<?php
 require('db.php');
 session_start();
 if (isset($_POST['username'])){
 $username = $_POST['username'];
 $password = $_POST['password'];
 $username = stripslashes($username);
 $username = mysql_real_escape_string($username);
 $password = stripslashes($password);
 $password = mysql_real_escape_string($password);
 //Checking is user existing in the database or not
 $query = "SELECT * FROM `login` WHERE name='$username' and password='".md5($password)."'";
 $result = mysql_query($query) or die(mysql_error());
 $rows = mysql_num_rows($result);
 if($rows==1){
 $_SESSION['username'] = $username;
 header("Location: introduction.html"); 
 }
 else {
 echo "<div class='form'><h3>Username/password is incorrect.</h3><br>Click here to <a href='login.php'>Login</a></div>";
 }
 }
?>
<div class="form">
<h1>Log In</h1>
<form action="" method="post" name="login">
Username: <input type="text" name="username" placeholder="Username" required /><br><br>
Password: <input type="password" name="password" placeholder="Password" required /><br><br>
<input name="submit" type="submit" value="Login" />
</form>
<p>Not registered yet? <a href='signup.php'>Register Here</a></p>
</div>

</body>
</html>