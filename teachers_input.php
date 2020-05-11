<?php 
	include("user_session_control.php");
	if (empty($_SESSION["username"]) || $_SESSION["role"] != "administrator" ) header("location: index.php");
	include("teachers_io.php");
	$page_now="teachers";
?>

<?php 
	if(isset($_GET["edit"]) || isset($_GET["delete"])) {
		$first_name = $_GET["first_name"];
		$last_name = $_GET["last_name"];
		$username_input = $_GET["username_input"];
		setCookie("old_username_input", $username_input);
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

<?php if (!isset($_GET["edit"]) && !isset($_GET["delete"])) { ?>
<h2><strong><u>Вписване</u></strong> / Редактиране / Изтриване на учител</h2>
<?php } else if (isset($_GET["edit"])) { ?>
<h2>Вписване / <strong><u>Редактиране</u></strong> / Изтриване на учител</h2>
<?php } else if (isset($_GET["delete"])) { ?>
<h2>Вписване / Редактиране / <strong><u>Изтриване</u></strong> на учител</h2>
<?php } ?>

<div class="container-fluid">
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<form method="post" name="form" action="teachers_input.php">
			<?php include("errors_success_messages.php"); ?>
			<div class="form-group">
				<label>Име</label>
				<input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>" placeholder="Име на учителя">
			</div>
			<div class="form-group">
				<label>Фамилия</label>
				<input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>" placeholder="Фамилия на учителя">
			</div>
			<div class="form-group">
				<label>Потребителско име</label>
				<input type="text" name="username" class="form-control" value="<?php echo $username_input; ?>" placeholder="Потребителско име за вход в системата">
			</div>
			<div class="form-group">
				<label>Парола</label>
				<input type="text" name="password" class="form-control" placeholder="Парола за достъп до системата">
			</div>
			
			<?php if(isset($_GET["edit"])){ ?>
				<button type="submit" name="edit_teacher" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Редактирай</button>
				<a href="teachers.php" class="btn btn-default">Отказ</a>
			<?php } else if(isset($_GET["delete"])){ ?>
				<button type="submit" name="delete_teacher" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Изтрий</button>
				<a href="teachers.php" class="btn btn-default">Отказ</a>
			<?php } else { ?>
				<button type="submit" name="submit_teacher" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-open"></span> Въведи</button>
				<a href="teachers.php" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Виж всички</a>
			<?php } ?>
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