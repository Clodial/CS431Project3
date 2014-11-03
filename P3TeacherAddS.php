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

	$student = $_POST["student"];
	$class = $_POST["class"];
	$assignment = $_POST["assign"];
	$gr = $_POST["gr"];
	$user = $_SESSION["username"];

	$user = mysql_real_escape_string($user);
	$class = mysql_real_escape_string($class);
	$assignment = mysql_real_escape_string($assignment);
	$gr = mysql_real_escape_string($gr);
	$student = mysql_real_escape_string($student);
?>
</head>
<body>
<div id="back-update">
<?php

	$sql2 = "select * from EdParticipate where class='$class' and userTa='$user' and userSt='$student'";
	$que =  mysql_query($sql2) or die (mysql_error());
	$c = mysql_num_rows($que);
	if($c > 0){
		$sql2 = "insert into EdGrades(userTeach,userStudent,class, Assignment, grade) values('$user','$student','$class','$assignment','$gr')";
		if(mysql_query($sql2)){
			echo "<h1>Student Graded!</h1>";
		}else{
			echo mysql_error();
			echo "<h1>Grading Failed!</h1>";
		}
	}
	echo "<a href=\"P3Teacher.php\">Back To Teacher Controls</a>";
?>
</div>
</body>
</html>