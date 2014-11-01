<html>
<head>
	<?php
		session_start();
		$_SESSION['view'] = $_SESSION['view'] + 1;
		//This is the login page so it has to be this way
		$_SESSION['password'] = null;
		if(isset($_SESSION['password'])){
			unset($_SESSION['password']);
		}

		//make sure to hide personal info
		include("../account.php");

		//make the connection
		$mysqli = new mysqli($hostname, $username, $password, $project);
		if(mysqli_connect_errno()){
			echo mysqli_connect_errno();
			exit();
		}
	?>
</head>
<body>
	<!--Basic Login Features-->
	<!--Also, mind the login Regex, it's gonna be a difficult one-->
	<div id="fr-page-login">
		<form action="proj3_firstAuth.php">
			<label class="fr-page-text">Username</label>
				<input class="fr-page-input" id="user" type=text name="user" placeholder="Type Your Username."></br>
			<label class="fr-page-text">Password</label>
				<input id="fr-page-pass" class="fr-page-input" type="password" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$" name="pass" placeholder="Type Your Password."></br>
			<label class="fr-page-text">Confirm Password</label>
				<input id="fr-page-check" class="fr-page-input" type="password" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$" name="check" placeholder="Confirm Password."></br>
			<input class="fr-page-submit" type="submit" value="Login">
		</form>
	</div>
</body>
</html>