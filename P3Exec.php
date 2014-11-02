<html>
<head>
<?php
	ob_start();
	session_start();

	if(isset($_SESSION['password'])){
		print "hey you";
	}
	print $_SESSION['password'];

	include("../account.php");
	$dbh = mysql_connect ( $hostname, $username, $password )
				or    die ( "Unable to connect to MySQL database" );
	mysql_select_db( $project )  or die ("Incorrect database name");

?>
</head>
<body>
</body>
</html>