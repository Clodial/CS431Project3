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
	if($_SESSION["acttype"] != "Student"){
		header("Location: index.php"); /* Redirect browser */
		exit();
	}
?>
</head>
<body>
	<div id="header">
		<h1><?php echo $_SESSION["fullName"];?>'s Dashboard</h1>
	</div>
	<div id="body">
		<div id="student-lists">
		<div class="clear"></div>
			<div id="main-left-imp" class="width-half">
			<h2>Current Grades</h2>
				<?php
				//get grades of classes student is registered in
				//show the average
$user = $_SESSION["username"];
$sql2 = "select * from EdParticipate where userSt='$user'";
$que = mysql_query($sql2) or die(mysql_error());
while($r = mysql_fetch_array($que)){
	$class = $r["class"];
	$teacher = $r["userTa"];
	$sql3 = "select AVG(EdGrades.grade) as avg from EdGrades where class='$class' and userTeach='$teacher' and userStudent='$user'";
	$que2 = mysql_query($sql3) or die(mysql_error());
	$avg = "";
	while($rr = mysql_fetch_array($que2)){
		$avg = $rr["avg"];
	}
	$sql3 = "select CONCAT(fName, ' ', lName) as name from EdAccounts where user='$teacher'";
	$que2 = mysql_query($sql3) or die(mysql_error());
	$name = "";
	while($rr = mysql_fetch_array($que2)){
		$name = $rr["name"];
	}
	echo "<div>";
	echo "<p>" . $class . " with " . $name . ": " . $avg . "</p>";
	echo "</div>";
}
				?>
			</div>
			<div id="main-right-imp" class="width-half">
				<h2>Your Classmates</h2>
				<?php
				//get all of the students in classes in a every student's class
$user = $_SESSION["username"];
$sql2 = "select * from EdParticipate where userSt='$user'";
$que = mysql_query($sql2) or die(mysql_error());
while($r = mysql_fetch_array($que)){
	$class = $r["class"];
	$teacher = $r["userTa"];
	$sql3 = "select EdAccounts.email as em, CONCAT(EdAccounts.fName,' ', EdAccounts.lName) as name from EdAccounts where user IN (select userSt from EdParticipate where EdParticipate.userTa='$teacher' and EdParticipate.class='$class' and EdParticipate.userSt != '$user')";
	$que2 = mysql_query($sql3) or die(mysql_error());

	while($rr = mysql_fetch_array($que2)){
		echo "<div>";
		echo "<p>" . $class . ": " . " " . $rr["name"] . " can be reached at " . $rr["em"] . "</p>";
		echo "</div>";
	}
}
				?>
			</div>
			<div class="clear"></div>
			<div id="main-imp" class="width-full">
			<h1>All Grades</h1>
					<?php
					//show all the assignments, the class, the teacher, and the grade the student received
$user = $_SESSION["username"];
$sql2 = "select * from EdGrades where userStudent='$user'";
$que = mysql_query($sql2) or die(mysql_error());
while($r = mysql_fetch_array($que)){
	$grade = $r["grade"];
	$assign = $r["Assignment"];
	$class = $r["class"];
	$teacher = $r["userTeach"];
	$sql3 = "select CONCAT(fName, ' ', lName) as name from EdAccounts where user='$teacher'";
	$que2 = mysql_query($sql3) or die(mysql_error());
	$name = "";
	while($rr = mysql_fetch_array($que2)){
		$name = $rr["name"];
	}
	echo "<div>";
	echo "<p>Class: " . $class . " | Taught by: " . $name . "</p>";
	echo "<p>Assignment: " . $assign . " | Grade: " . $grade . "</p>";
	echo "</div>";
}
					?>
				</div>
		</div>

		<div id="main-Add1" class="width-full form-blue">
			<h2>Register for Class</h2>
			<form id="student-rForm" method="post" action="P3StudentAdd.php">
				<label class="admin-add-part">New Class *</label>
					<select name="class">
						<?php
$sql2 = "select EdClasses.ClassDir as class,EdClasses.classID as ind,CONCAT(EdAccounts.fName, ' ' , EdAccounts.lName) as name from EdClasses,EdAccounts where EdClasses.userTeacher=EdAccounts.user";
$t = mysql_query($sql2) or die(mysql_error());
while($r = mysql_fetch_array($t)){
	$teacher = $r["name"];
	$class = $r["class"];
	$rClass = $class . " taught by " . $teacher;
	echo "<option value='" . $r["ind"] . "'>" . $rClass . "</option>"; 
}
						?>
					</select></br>
				<input class="student-add" type="submit" value="Register for Class">
			</form>
		</div>
	</div>
	<div id="footer">
		<a href="index.php">Logout</a>
	</div>
</body>
</body>
</html>