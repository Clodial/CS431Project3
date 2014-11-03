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
		<div id="teach-lists" class="width-third">
			<div id="teach-assign" class="width-half">
				<h4>Graded Assignments</h4>
				<?php 
$teacher = $_SESSION['user'];
$reg = "select * from EdGrades where userTeach='$teacher'";
$que = mysql_query($reg) or die(mysql_error());
while($r = mysql_fetch_array($que)){
	$class = $r["class"];
	$stud = $r["userStudent"];
	$assignment = $r["Assignment"];
	$grade = $r["grade"];
	$count = 0;
	if($count % 2 == 0){
		echo "<div class=\"teach-cl section-grey\">";
		echo "<p> Class: " . $class . "</p>";
		echo "<p> Student: " . $stud . "</p>";
		echo "<p> Assignment: " . $Assignment . "</p>";
		echo "<p> Grade: " . $grade . "</p>";
		echo "</div>";
	}else{
		echo "<div class=\"teach-cl section-white\">";
		echo "<p> Class: " . $class . "</p>";
		echo "<p> Student: " . $stud . "</p>";
		echo "<p> Assignment: " . $Assignment . "</p>";
		echo "<p> Grade: " . $grade . "</p>";
		echo "</div>";
	}
}
				?>
			</div>
			<div id="teach-stud" class="width-half">
				<h4>Students taking classes</h4>
				<?php 
$teacher = $_SESSION['user'];
$reg = "select * from EdParticipate where userTa='$teacher'";
$que = mysql_query($reg) or die(mysql_error());
$count = 0;
while($r = mysql_fetch_array($que)){
	$stud = $r['userSt'];
	$class = $r['class'];
	$sql2 = "select * from EdAccounts where user='$stud'";
	$que2 = mysql_query($sql2) or die(mysql_error());
	$name = "";
	while($t = mysql_fetch_array($que2)){
		$name = $t["fName"] . " " . " " . $t["lName"];
	}
	$count = $count + 1;
	if($count % 2 == 0){
		echo "<div class=\"teach-st section-grey\">";
		echo "<p> Name: " . $name . " | Class: " . $class . "</p>";
		echo "</div>";
	}else{
		echo "<div class=\"teach-st section-white\">";
		echo "<p> Name: " . $name . " | Role: " . $class . "</p>";
		echo "</div>";
	}
}
				?>
			</div>
		</div>
		<div id="teach-asAdd" class="width-full">
			<!--Add Students-->
			<form id="teach-form-st" method="post" action="P3TeacherAddS.php">
				<label class="teach-add-part">Student *</label>
					<select name="student">
						<?php
$sql2 = "select * from EdAccounts where type='Student'";
$t = mysql_query($sql2) or die(mysql_error());
while($r = mysql_fetch_array($t)){
	$name = $r["fName"] . " " . " " . $r["lName"];
	echo "<option value='" . $r["user"]."'>" . $name . "</option>";
}
						?>
					</select></br>
				<label class="teach-add-part">Class *</label>
					<select name="class">
						<?php
$teach = $_SESSION["username"];
echo $teach;
$sql2 = "select * from EdClasses where userTeacher='$teach'";
$t = mysql_query($sql2) or die(mysql_error());
while($r = mysql_fetch_array($t)){
	$class = $r["ClassDir"];
	echo "<option value='" . $r["ClassDir"]."'>" . $class . "</option>";
}
						?>
					</select></br>
				<label class="teach-add-part">Assignment *</label>
					<input class="teach-page-input" required type=text name="assign" placeholder="Assignment" autocomplete="off"></br>
				<label class="teach-add-part">Grade *</label>
					<input class="teach-page-input" required type=text name="gr" placeholder="Grade" pattern="[0-9]{1,3}$" autocomplete="off"></br>
				<input class="teach-add-part" type="submit" value="Grade!">
			</form>
		</div>
	</div>
	<div id="footer">
		<a href="index.php">Logout</a>
	</div>
</body>
</body>
</html>