<html>
<head>
	<?php
		ob_start();
		session_start();
		$_SESSION['view'] = $_SESSION['view'] + 1;
		//This is the login page so it has to be this way
		$_SESSION["password"] = null;
		if(isset($_SESSION["password"])){
			unset($_SESSION["password"]);
		}
		$_SESSION["username"] = null;
		if(isset($_SESSION["username"])){
			unset($_SESSION["username"]);
		}
		$_SESSION["acttype"] = null;
		if(isset($_SESSION["acttype"])){
			unset($_SESSION["acttype"]);
		}
		$_SESSION["fullName"] = null;
		if(isset($_SESSION["fullName"])){
			unset($_SESSION["fullName"]);
		}
		//make sure to hide personal info
		include("../account.php");

	?>
	<script type="text/javascript">
		function checkPass(){
			var p = document.getElementById("fr-page-pass").value;
			var c = document.getElementById("fr-page-check").value;
			var s = document.getElementById("fr-page-span");
			if(p === c){
				s.style.color = "#000000";
				s.style.backgroundColor = "#00ff00";
				s.innerHTML = "Password Match!";
			}else{
				s.style.color = "#000000";
				s.style.backgroundColor = "#ff0000";
				s.innerHTML = "Password Mismatch";
				document.getElementById("fr-page-pass").value = "";
				document.getElementById("fr-page-check").value = "";
			}
		}
	</script>
</head>
<body>
	<!--Basic Login Features-->
	<!--Also, mind the login Regex, it's gonna be a difficult one-->
	<div id="fr-page-login">
		<form method="post" action="Proj3LogCheck.php">
			<label class="fr-page-text">Username *</label>
				<input class="fr-page-input" id="fr-page-user" required type=text name="user" placeholder="Type Your Username." autocomplete="off"></br>
			<label class="fr-page-text">Password *</label>
				<input id="fr-page-pass" class="fr-page-input" required type="password" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$" name="pass" placeholder="Type Your Password." autocomplete="off"></br>
			<label class="fr-page-text">Confirm Password *</label>
				<input id="fr-page-check" class="fr-page-input" required type="password" pattern="^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$" name="check" placeholder="Confirm Password." autocomplete="off" onblur="checkPass()"></br>
			<input class="fr-page-submit" type="submit" value="Login">
		</form></br>
		<span id="fr-page-span"></span>
	</div>
</body>
</html>