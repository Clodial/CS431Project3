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
	<div id="admin-msg" class="width-full">
	<h5 id="admin-msg-list">Current Classes</h5>
		<?php
$reg = "select * from EdAdditions";
$que = mysql_query($reg) or die(mysql_error());
$num = mysql_num_rows($que);
while($r = mysql_fetch_array($que)){
	if(($r["AdditionID"] == $num) || ($r["AdditionID"] == $num - 1 && $num - 1 > 0) || ($r["AdditionID"] == $num - 2 && $num - 2 > 0)){
		echo "<p class=\"admin-msgl\">" . $r["Addition"] . "</p>";
	}
}
		?>
	</div>
	<div id="admin-lists" class="width-full">
		<div id="admin-class" class="width-half">
			<?php 
$reg = "select * from EdClasses";
$que = mysql_query($reg) or die(mysql_error());
while($r = mysql_fetch_array($que)){
	$class = $r["ClassDir"];
	$teacher = $r["userTeacher"];
	$count = 0;
	if($count % 2 == 0){
		echo "<div class=\"admin-cl section-grey\">";
		echo "<p> Class: " . $class . "</p>";
		echo "<p> Taught by: " . $teach . "</p>";
		echo "</div>";
	}else{
		echo "<div class=\"admin-cl section-white\">";
		echo "<p> Class: " . $class . "</p>";
		echo "<p> Taught by: " . $teach . "</p>";
		echo "</div>";
	}
}
			?>
		</div>
		<div id="admin-stud" class="width-half">
			<?php 
$reg = "select * from EdAccounts where type='Student'";
$que = mysql_query($reg) or die(mysql_error());
$count = 0;
while($r = mysql_fetch_array($que)){
	$name = $r["fName"] . " " . " " . $r["lName"];
	$role = $r["type"];
	$count = $count + 1;
	if($count % 2 == 0){
		echo "<div class=\"admin-st section-grey\">";
		echo "<p> Name: " . $name . " | Role: " . $role . "</p>";
		echo "</div>";
	}else{
		echo "<div class=\"admin-st section-white\">";
		echo "<p> Name: " . $name . " | Role: " . $role . "</p>";
		echo "</div>";
	}
}
			?>
		</div>
	</div>
	<div id="admin-stAdd" class="width-full">
		<!--Add Students-->
		<form id="admin-form-st" method="post" action="P3AdminAddS.php">
			<label class="admin-add-part">New Student Username *</label>
				<input class="admin-page-input" required type=text name="user" pattern="^[a-z]{3}[0-9]{2,5}$" placeholder="New Username" autocomplete="off"></br>
			<label class="admin-add-part">New Student Password *</label>
				<input class="admin-page-input" required type=text name="pass" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$" placeholder="Insert Password" autocomplete="off"></br>
			<label class="admin-add-part">First Name *</label>
				<input class="admin-page-input" required type=text name="fname" placeholder="First Name" autocomplete="off"></br>
			<label class="admin-add-part">Last Name *</label>
				<input class="admin-page-input" required type=text name="lname" placeholder="Last Name" autocomplete="off"></br>
			<input class="admin-add-part" type="submit" value="Add Student">
		</form>
	</div>
	<div id="admin-clAdd" class="width-full">
		<!--Add Classes-->
		<form id="admin-form-cl" method="post" action="P3AdminAddC.php">
			<label class="admin-add-part">New Class *</label>
				<input class="admin-page-input" required type=text name="class" pattern="[A-Z]{2}[0-9]{3}$" placeholder="New Class" autocomplete="off"></br>
			<label class="admin-add-part">Teacher *</label>
				<select name="teacher">
					<?php
$sql2 = "select * from EdAccounts where type='Teacher'";
$t = mysql_query($sql2) or die(mysql_error());
while($r = mysql_fetch_array($t)){
	$name = $r["fName"] . " " . " " . $r["lName"];
	echo "<option value='" . $r["user"]."'>" . $name . "</option>";
}
					?>
				</select>
			<label class="admin-add-part">Section *</label>
			<input class="admin-add-part" type="submit" value="Add Class">
		</form>
	</div>
	<div id="footer">
		<a href="index.php">Logout</a>
	</div>
</body>
</body>
</html>