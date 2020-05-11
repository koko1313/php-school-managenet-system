<?php 
	include("user_session_control.php"); 
	include("profile_control.php");
	$page_now="index";
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

<h1><?php echo $school_name ?></h1>

<div class="container-fluid">
<div class="row">
	
	<div class="col-md-7 col-md-push-5">
	<?php include("errors_success_messages.php"); ?>
		<?php if(empty($_SESSION["username"])) { ?>
		<h2>Вход</h2>
		<form method="post" name="form" action="index.php">
			<div class="form-group">
				<label>Потребителско име</label>
				<div class="input-group mb-2 mb-sm-0">
					<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
					<input type="text" name="username" class="form-control" value="<?php echo $username; ?>" placeholder="Потребителско име">
			    </div>
			</div>
			<div class="form-group">
				<label>Парола</label>
				<div class="input-group mb-2 mb-sm-0">
					<div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
					<input type="password" name="password" class="form-control" value="<?php echo $password; ?>" placeholder="Парола">
				</div>
			</div>
			
			<button type="submit" name="login" class="btn btn-primary">Вход <span class="glyphicon glyphicon-log-in"></span></button>
		</form>
		<?php } else { ?>
			<?php if ($_SESSION["role"] != "administrator") print_personal_information(); ?>
			<?php if ($_SESSION["role"] === "administrator") { ?>
				<a href="admin_change_password.php">Промяна на паролата</a>
			<?php } ?>
		<?php } ?>	
	</div>
	
	<div class="col-md-5 col-md-pull-7">
		<p><pre><?php echo $school_description ?></pre></p>
		<img class="img-rounded img-responsive" src="images/school_picture.jpg">
	</div>
	
</div>
</div>

<?php include("footer.php"); ?>

<script src="scripts/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="scripts/bootstrap.min.js"></script>
</body>
</html>