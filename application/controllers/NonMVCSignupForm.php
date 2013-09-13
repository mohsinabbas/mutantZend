<?php
if($_POST){
//Initialize user input.
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$errors = array();
//Validate data
if($username == ''){
	array_push($errors, "The username can not be empty");
}
if($email == ""){
	array_push($errors, "The email can not be empty");
}
if($password == ""){
	array_push($errors, "The password can not be empty");
}
//If no errors add otherwise show error.
$conn = mysql_connect($app_server, $app_username, $app_password);
mysql_select_db($app_db, $conn);
$statement = "INSERT INTO Users (username, password, email)
VALUES ('".$username."', '".$password."', '".$email."')";

if(mysql_query($statement)){
	$success = true;
}
else{
	$sucess = false;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-
strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>LoudBite.com</title>
</head>
<body>
	<?php
    if($errors){
		foreach($errors as $error){
			echo $error."<br/>";
		}
    }
    if($success === true){
    	echo "Thank you!. You're now part of the site.";
    }
	else{
    ?>
    <form action="/account/signup" method="POST">
        Username: <input type="text" name="username" /><br/>
        Password: <input type="password" name="password" /><br/>
        Email: <input type="text" name="email" /><br/>
        <input type="submit" value=" Create my account! " /><br/>
    </form>
    <?php } ?>
</body>
</html>