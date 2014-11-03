<html>
<head>
<?php
	ob_start();
	session_start();
	include("../account.php");
	$dbh = mysql_connect ( $hostname, $username, $password )
		or die ( "Unable to connect to MySQL database" );
	mysql_select_db( $project )  or die ("Incorrect database name");
?>
</head>
<body>
	<div id="header">
		<h1><?php echo $_SESSION["fullName"];?>'s Dashboard</h1>
	</div>
	<div id="body">
		<div id="student-lists">
			<div id="student-grades" class="width-full">
			<h4>Current Grades</h4>
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
	echo "<p>" . $class . " with " . $teacher . ": " . $avg . "</p>";
}
				?>
			</div>
			<div id="student-email" class="width-full">
			<h4>Your Classmates</h4>
				<?php
				//get all of the students in classes in a every student's class
$user = $_SESSION["username"];
$sql2 = "select * from EdParticipate where userSt='$user'";
$que = mysql_query($sql2) or die(mysql_error());
$count = 0;
while($r = mysql_fetch_array($que)){
	$class = $r["class"];
	$teacher = $r["userTa"];
	$sql3 = "select EdAccounts.email as em, CONCAT(EdAccounts.fName,' ', EdAccounts.lName) as name from EdAccounts where user IN (select userSt from EdParticipate where EdParticipate.userTa='$teacher' and EdParticipate.class='$class' and EdParticipate.userSt != '$user')";
	$que2 = mysql_query($sql3) or die(mysql_error());

	while($rr = mysql_fetch_array($que2)){
		if($count % 2 == 0){
			echo "<p>" . $class . ": " . " " . $rr["name"] . " can be reached at " . $rr["em"] . "</p>";
		}else{
			echo "<p>" . $class . ": " . " " . $rr["name"] . " can be reached at " . $rr["em"] . "</p>";
		}
		$count = $count + 1;
	}
}
				?>
			</div>
			<div id="student-assign" class="width-full">
			<h4>All Grades</h4>
					<?php
					//show all the assignments, the class, the teacher, and the grade the student received
$user = $_SESSION["username"];
$sql2 = "select * from EdGrades where userStudent='$user'";
$que = mysql_query($sql2) or die(mysql_error());
$count = 0;
while($r = mysql_fetch_array($que)){
	$grade = $r["grade"];
	$assign = $r["Assignment"];
	$class = $r["class"];
	$teacher = $r["userTeach"];
	if($count % 2 == 0){
		echo "<p>Class: " . $class . " | Taught by: " . $teacher . "</p>";
		echo "<p>Assignment: " . $assign . " | Grade: " . $grade . "</p>";
	}else{
		echo "<p>Class: " . $class . " | Taught by: " . $teacher . "</p>";
		echo "<p>Assignment: " . $assign . " | Grade: " . $grade . "</p>";
	}
	$count = $count + 1;
}
					?>
				</div>
		</div>
		<div id="student-register" class="width-full">
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