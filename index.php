<html>
<head>
<?php
	session_start();
	$_SESSION['view'] = $_SESSION['view'] + 1;
	//This is the login page so it has to be this way
	$_SESSION['password'] = null;
	if(isset($_SESSION['password'])){
		unset($_SESSION['password']);
	}

	//make sure to hide personal info
	include("../account.php");

	//make the connection
	$mysqli = new mysqli($hostname, $username, $password, $project);
	if(mysqli_connect_errno()){
		echo mysqli_connect_errno();
		exit();
	}
?>


</head>
<body>
</body>
</html>