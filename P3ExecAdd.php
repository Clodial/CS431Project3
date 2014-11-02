<html>
<head>
<?php
	ob_start();
	session_start();

	include("../account.php");
	$dbh = mysql_connect ( $hostname, $username, $password )
		or die ( "Unable to connect to MySQL database" );
	mysql_select_db( $project )  or die ("Incorrect database name");

	$user = $_POST["user"];
	$pass = $_POST["pass"];
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$type = $_POST["type"];

	$user = mysql_real_escape_string($user);
	$pass = mysql_real_escape_string($pass);
	$fname = mysql_real_escape_string($fname);
	$lname = mysql_real_escape_string($lname);
	$type = mysql_real_escape_string($type);

	$email = $user . "@Clodial.com";
	$sha = sha1($pass);
?>
</head>
<body>
<?php
	$check = true;
	$sql2 = "select * from EdAccounts where user='$user'";
	$t = mysql_query($sql2) or die(mysql_error());
	if(mysql_num_rows($t) > 0){
		$check = false;
	}

	$sql2 = "insert into EdAccounts(user,pass,type,fName,lName,email) values('$user','$sha','$type','$fname','$lname','$email')";
	if(mysql_query($sql2) || $check == false){
		echo "<h1>User Added!</h1>";
	}else{
		echo mysql_error();
		echo "<h1>Addition Failed!";
	}
	echo "<a href=\"P3Exec.php\">Back To Executive Controls</a>";
?>
</body>
</html>