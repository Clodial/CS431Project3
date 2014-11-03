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

	$class = $_POST["class"];
	$teacher = $_POST["teacher"];

	$class = mysql_real_escape_string($class);
	$teacher = mysql_real_escape_string($teacher);

	$sql2 = "select * from EdAccounts where user='$teacher'";
	$que = mysql_query($sql2) or die(mysql_error());
	$name = "";
	while($r = mysql_fetch_array($que)){
		$name = $r["fName"] . " " . $r["lName"];
	}


	$msg = $_SESSION["fullName"] . " added the class " . $class . " taught by: " . $name;
	$sql2 = "insert into EdAdditions(Addition) values('$msg')";
	$do = mysql_query($sql2) or die(mysql_error());
?>
</head>
<body>
<div id="back-update">
<?php
	$sql2 = "insert into EdClasses(userTeacher, ClassDir) values('$teacher','$class')";
	if(mysql_query($sql2)){
		echo "<h1>Class Added!</h1>";
	}else{
		echo "<h1>Addition Failed!</h1>";
	}
	echo "<a href=\"P3Admin.php\">Back To Administrator Controls</a>";
?>

</div>
</body>
</html>