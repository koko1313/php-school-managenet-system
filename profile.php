<?php 
	include("user_session_control.php");
	include("profile_control.php");
	if (empty($_SESSION["username"])) header("location: index.php");
	$page_now="profile";
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
<?php include("errors_success_messages.php"); ?>

<?php include("nav-bar.php"); ?>

<div class="container-fluid">
	<div class="row">
		<div class="col text-center">

			<?php if ($_SESSION["role"] != "administrator") print_personal_information(); ?>
			<?php if ($_SESSION["role"] === "administrator") { ?>
				<a href="admin_change_password.php">Промяна на паролата</a>
			<?php } ?>
		</div>
	</div>
</div>

<?php include("footer.php"); ?>

<script src="scripts/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="scripts/bootstrap.min.js"></script>
</body>
</html>