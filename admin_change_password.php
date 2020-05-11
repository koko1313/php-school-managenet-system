<?php
	include("user_session_control.php");
	if (empty($_SESSION["username"]) || $_SESSION["role"] != "administrator" ) header("location: index.php");
	include("db_config.php");
	
	// проверяваме дали е позволеня смяна на паролата
	$allow_password_change = $db_sms->query("SELECT allow_password_change FROM administrator WHERE username='administrator'");
	$allow_password_change = mysqli_fetch_array($allow_password_change);
	if (!$allow_password_change["allow_password_change"]) header("location: profile.php");
	$page_now="admin_change_password";
?>

<?php

$input_errors = array(); // масив, в който ще пазим грешките от празни input полета
$input_success = array(); // масив, в който ще пазим успехите от input

if (isset($_POST["change_password"])) {
	$password = $_POST["password"];
	$password_confirm = $_POST["password_confirm"];
	
	if (strlen($password)==0 || strlen($password_confirm)==0) {
		array_push($input_errors, "Моля попълнете всички полета");
	} else
	if ($password != $password_confirm) {
		array_push($input_errors, "Паролите не съвпадат");
	} else {
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);
		
		$query = "UPDATE administrator SET password='$hashed_password', allow_password_change='0' WHERE username='administrator'";
		
		if ($db_sms->query($query)) {
			header("location: profile.php?success=3");
		} else {
			header("location: profile.php?error=3");
		}
	}
	
	
}

?>

<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="styles/style.css">
</head>
<body>

<?php include("nav-bar.php"); ?>

<h2>Промяна на администраторската парола</h2>

<div class="container-fluid">
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<form method="post" name="form" action="admin_change_password.php">
			<?php include("errors_success_messages.php"); ?>
			<div class="form-group">
				<label>Нова парола</label>
				<input type="password" name="password" class="form-control">
			</div>
			<div class="form-group">
				<label>Повтори новата парола</label>
				<input type="password" name="password_confirm" class="form-control">
			</div>
			
			<button type="submit" name="change_password" class="btn btn-primary">Промени</button>

		</form>
	</div>
</div>
</div>

<?php include("footer.php"); ?>	


<script src="scripts/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="scripts/bootstrap.min.js"></script>
</body>
</html>

