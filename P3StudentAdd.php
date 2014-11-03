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

	$ind = $_POST["class"];
	$ind = mysql_real_escape_string($ind);


	$user = $_SESSION["username"];
	$class = "";
	$teacher = "";
	$sql2 = "select * from EdClasses where classID='$ind'";
	$que = mysql_query($sql2) or die(mysql_error());
	while($r = mysql_fetch_array($que)){
		$class = $r["ClassDir"];
		$teacher = $r["userTeacher"];
	}

?>
</head>
<body>
<div id="back-update">
<?php
$sql2 = "select * from EdParticipate where userSt='$user' and class='$class'";
$que = mysql_query($sql2) or die(mysql_error());
$t = mysql_num_rows($que);
if($t <= 0){
	$sql3 = "insert into EdParticipate(userSt,userTa,class) values('$user','$teacher','$class')";
	if(mysql_query($sql3)){
		echo "<h1>Registered into a class!</h1>";
	}else{
		echo mysql_error();
		echo "<h1>Registration Failed!</h1>";
	}
}else{
		echo mysql_error();
		echo "<h1>Already Registered!</h1>";
}

echo "<a href=\"P3Student.php\">Back To Student Controls</a>";
?>
</div>
</body>
</html>