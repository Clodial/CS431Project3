<html>
<?php
	$_SESSION['view'] = $_SESSION['view'] + 1;
	
	include("../account.php");
	$dbh = mysql_connect ( $hostname, $username, $password )
				or    die ( "Unable to connect to MySQL database" );
	mysql_select_db( $project )  or die ("Incorrect database name");

	$name = "";
	$type = "";

	//Password and Username Check
	$pCheck = false;
	
	$user = $_GET["user"];
	$pass = $_GET["pass"];
	//prevent injections
	$user = mysql_real_escape_string($user);
	$pass = mysql_real_escape_string($pass);

	$_SESSION['password'] = $pass;
	$_SESSION['username'] = $user;
	print $pass;
	print $user;

	$c = 0;
	$sql2 = "select * from EdAccounts where user='$user' and pass='$pass'";
	$t = mysql_query($sql2) or die(mysql_error());
	$c = mysql_num_rows($t);
	if($c > 0){
		$pCheck = true;
	}
?>

<body>
<div id="p3-CheckBoard">
<?php
//set up if successful
	if($pCheck == true){
		$sql2 = "select * from EdAccounts where user='$user' and pass='$pass'";
		$t = mysql_query($sql2) or die(mysql_error());
		while($r = mysql_fetch_array($t)){
			print "hey";
			$type = $r['type'];
			$_SESSION['acttype'] = $type;
			$name = $r['fName'] . " " . $r['lName'];
			$_SESSION['fullName'] = $name;
		}
		//print out a successful continue and continue
		echo "<p class=\"p3-checktest\">Welcome, ". $name ."!</p>";
		if($type == 'Executive'){
			echo "<a class=\"p3-checktest\" href=\"P3Exec.php\">Continue to Executive Controls</a>";
		}else if($type == 'Staff'){
			echo "<a class=\"p3-checktest\" href=\"P3Staff.php\">Continue to Staff Controls</a>";
		}else if($type == 'Teacher'){
			echo "<a class=\"p3-checktest\" href=\"P3Teacher.php\">Continue to Teacher Controls</a>";
		}else{
			echo "<a class=\"p3-checktest\" href=\"P3Student.php\">Continue to Student Controls</a>";
		}

	}else{
		//Set up if unsuccessful
		echo "<p class=\"p3-checktest\">Login Unsuccessful</p>";
		echo "<a class=\"p3-checktest\" href=\"index.php\">Back To Login</a>";	
		session_destroy();
	}
?>
</div>
</body>
</html>