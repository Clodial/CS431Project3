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

	<div id="exec-message" class="width-full">
		<h4 id="exec-msg-head">Recent Additions</h4>
		<?php
$reg = "select * from EdAdditions";
$que = mysql_query($reg) or die(mysql_error());
$num = mysql_num_rows($que);
while($r = mysql_fetch_array($que)){
	if(($r["AdditionID"] == $num) || ($r["AdditionID"] == $num - 1 && $num - 1 > 0) || ($r["AdditionID"] == $num - 2 && $num - 2 > 0)){
		echo "<p class=\"exec-msg\">" . $r["Addition"] . "</p>";
	}
}
		?>
	</div>
	<div id="exec-lists" class="width-full">
		<div id="exec-classes" class="width-half">
			<h5 id="exec-class-List">Current Classes</h5>
			<?php
$reg = "select * from EdClasses";
$que = mysql_query($reg) or die(mysql_error());
while($r = mysql_fetch_array($que)){
	$class = $r['ClassDir'];
	$teach = $r['userTeacher'];

	if($r["classID"] % 2 == 0){
		echo "<div class=\"exec-cl section-blue\">";
		echo "<p> Class: " . $class . "</p>";
		echo "<p> Taught by: " . $teach . "</p>";
		echo "</div>";
	}else{
		echo "<div class=\"exec-cl section-orange\">";
		echo "<p> Class: " . $class . "</p>";
		echo "<p> Taught by: " . $teach . "</p>";
		echo "</div>";
	}
}
			?>
		</div>
		<div id="exec-staff" class="width-half">
		<h5 id="exec-staff-list">Current Staff</h5>
			<?php
$reg = "select * from EdAccounts where type='Staff' or type='Teacher'";
$que = mysql_query($reg) or die(mysql_error());
while($r = mysql_fetch_array($que)){
	$name = $r["fName"] . " " . " " . $r["lName"];
	$role = $r["type"];
	if($r["ActID"] % 2 == 0){
		echo "<div class=\"exec-st section-blue\">";
		echo "<p> Name: " . $name . " | Role: " . $role . "</p>";
		echo "</div>";
	}else{
		echo "<div class=\"exec-st section-orange\">";
		echo "<p> Name: " . $name . " | Role: " . $role . "</p>";
		echo "</div>";
	}
}
			?>
		</div>
	</div>
	<div id="exec-add" class="width-full">
		<form method="post" action="P3ExecAdd.php">
			<label class="exec-add-part">New Employee Username *</label>
				<input class="exec-page-input" required type=text name="user" pattern="^[a-z]{3}[0-9]{2,5}$" placeholder="New Username" autocomplete="off"></br>
			<label class="exec-add-part">New Employee Password *</label>
				<input class="exec-page-input" required type=text name="pass" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$" placeholder="Insert Password" autocomplete="off"></br>
			<label class="exec-add-part">First Name *</label>
				<input class="exec-page-input" required type=text name="fname" placeholder="First Name" autocomplete="off"></br>
			<label class="exec-add-part">Last Name *</label>
				<input class="exec-page-input" required type=text name="lname" placeholder="Last Name" autocomplete="off"></br>
			<label class="exec-add-part">Employee Type *</label>
				<select name="type"></br>
					<option value="Teacher">Teacher</option>
					<option value="Staff" selected>Administrator</option>
				</select>
			<input class="exec-add-part" type="submit" value="Add Employee">
		</form>
	</div>
</body>
</html>