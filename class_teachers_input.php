<?php 
	include("user_session_control.php");
	if (empty($_SESSION["username"]) || $_SESSION["role"] != "administrator" ) header("location: index.php");
	include("class_teachers_io.php");
	$page_now="class_teachers";
?>

<?php 
	if(isset($_GET["edit"]) || isset($_GET["delete"])) {
		$class_id = $_GET["class"];
		$teacher_id = $_GET["teacher"];
		setCookie("old_class", $class_id);
		setCookie("old_teacher", $teacher_id);
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
<h2><strong><u>Вписване</u></strong> / Редактиране / Изтриване на клас-учител</h2>
<?php } else if (isset($_GET["edit"])) { ?>
<h2>Вписване / <strong><u>Редактиране</u></strong> / Изтриване на клас-учител</h2>
<?php } else if (isset($_GET["delete"])) { ?>
<h2>Вписване / Редактиране / <strong><u>Изтриване</u></strong> на клас-учител</h2>
<?php } ?>

<div class="container-fluid">
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<form method="post" name="form" action="class_teachers_input.php">
			<?php include("errors_success_messages.php"); ?>
			<div class="form-group">
				<select name="class" class="form-control">
				  <option value="0">Клас</option>
				  <?php echo createOptions("classes_with_label"); ?>
				</select>
			</div>
			<div class="form-group">
				<select name="teacher" class="form-control">
				  <option value="0">Учител</option>
				  <?php echo createOptions("teachers"); ?>
				</select>
			</div>
			
			<?php if(isset($_GET["edit"])){ ?>
				<button type="submit" name="edit_class_teacher" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Редактирай</button>
				<a href="class_teachers.php" class="btn btn-default">Отказ</a>
			<?php } else if(isset($_GET["delete"])){ ?>
				<button type="submit" name="delete_class_teacher" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Изтрий</button>
				<a href="class_teachers.php" class="btn btn-default">Отказ</a>
			<?php } else { ?>
				<button type="submit" name="submit_class_teacher" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-open"></span> Въведи</button>
				<a href="class_teachers.php" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Виж всички</a>
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