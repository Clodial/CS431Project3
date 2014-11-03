<html>
<head>
<link href="../_inc/stylesheet.css" type="text/css" rel="stylesheet" />
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

	$user = mysql_real_escape_string($user);
	$pass = mysql_real_escape_string($pass);
	$fname = mysql_real_escape_string($fname);
	$lname = mysql_real_escape_string($lname);

	$sha = sha1($pass);
	$type = "Student";

	$msg = $_SESSION["fullName"] . " added " . $fname . " " . $lname;
	$sql2 = "insert into EdAdditions(Addition) values('$msg')";
	$do = mysql_query($sql2) or die(mysql_error());
	$email = $user . "@Clodial.com";
?>
</head>
<body>
<div id="back-update">
<?php
	$sql2 = "insert into EdAccounts(user,pass,type,fName,lName,email) values('$user','$sha','$type','$fname','$lname','$email')";
	if(mysql_query($sql2)){
		echo "<h1>User Added!</h1>";
	}else{
		echo "<h1>Addition Failed!</h1>";
	}
	echo "<a href=\"P3Admin.php\">Back To Administrator Controls</a>";
?>
</div>
</body>
</html>