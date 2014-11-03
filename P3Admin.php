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
	if($_SESSION["acttype"] != "Staff"){
		header("Location: index.php"); /* Redirect browser */
		exit();
	}
?>
</head>
<body>
	<div id="header">
		<h1><?php echo $_SESSION["fullName"];?>'s Dashboard</h1>
	</div>


<div id="main-imp" class="width-full">
	<h1 id="admin-msg-list">Lastest Info</h1>
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
	<div class="clear"></div>
	<div id="main-left-imp" class="width-half">
		<h1 id="admin-msg-list">Available Classes</h1>
			<?php 
$reg = "select * from EdClasses";
$que = mysql_query($reg) or die(mysql_error());
while($r = mysql_fetch_array($que)){
	$class = $r["ClassDir"];
	$teacher = $r["userTeacher"];
	$count = 0;
	$sql3 = "select CONCAT(fName, ' ', lName) as name from EdAccounts where user='$teacher'";
	$que2 = mysql_query($sql3) or die(mysql_error());
	$name = "";
	while($rr = mysql_fetch_array($que2)){
		$name = $rr["name"];
	}
	if($count % 2 == 0){
		echo "<div class=\"admin-cl section-grey\">";
		echo "<p> Class: " . $class . "</p>";
		echo "<p> Taught by: " . $name . "</p>";
		echo "</div>";
	}else{
		echo "<div class=\"admin-cl section-white\">";
		echo "<p> Class: " . $class . "</p>";
		echo "<p> Taught by: " . $name . "</p>";
		echo "</div>";
	}
}
			?>
	</div>
	<div id="main-right-imp" class="width-half">
		<h1 id="admin-msg-list">Student Master List</h1>
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
	<div class="clear"></div>
	<div id="main-Add1" class="width-full form-blue">
		<!--Add Students-->
		<h2>Add Student</h2>
		<form id="admin-form1" method="post" action="P3AdminAddS.php">
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
	<div id="main-Add2" class="width-full form-blue">
		<!--Add Classes-->
		<h2>Add Class</h2>
		<form id="admin-form2" method="post" action="P3AdminAddC.php">
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
				</select></br>
			<input class="admin-add-part" type="submit" value="Add Class">
		</form>
	</div>
	<div id="footer">
		<a href="index.php">Logout</a>
	</div>
</body>
</body>
</html>