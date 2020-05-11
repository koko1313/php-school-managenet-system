<?php 
	include("students_io.php");
	include("user_session_control.php");
	if (empty($_SESSION["username"]) || !($_SESSION["role"] === "administrator" || $_SESSION["role"] === "class teacher") ) header("location: index.php");
	$page_now="students";
?>

<?php 
	if(isset($_GET["edit"]) || isset($_GET["delete"])) {
		$query = "SELECT * FROM students WHERE egn=".$_GET['egn'];
		$student = mysqli_fetch_array($db_sms->query($query));
		
		$egn = $student["egn"];
		$first_name = $student["first_name"];
		$second_name = $student["second_name"];
		$last_name = $student["last_name"];
		$class_no = $student["class_no"];
		$class_id = $student["class_id"];
		$username_input = $student["username"];
		$description = $student["description"];
		
		setCookie("old_egn", $egn);
		setCookie("old_first_name", $first_name);
		setCookie("old_second_name", $second_name);
		setCookie("old_last_name", $last_name);
		setCookie("old_class_no", $class_no);
		setCookie("old_class_id", $class_id);
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
<h2><strong><u>Вписване</u></strong> / Редактиране / Изтриване на ученик</h2>
<?php } else if (isset($_GET["edit"])) { ?>
<h2>Вписване / <strong><u>Редактиране</u></strong> / Изтриване на ученик</h2>
<?php } else if (isset($_GET["delete"])) { ?>
<h2>Вписване / Редактиране / <strong><u>Изтриване</u></strong> на ученик</h2>
<?php } ?>

<div class="container-fluid">
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<form method="post" name="form" action="students_input.php">
			<?php include("errors_success_messages.php"); ?>
			<div class="form-group">
				<label>ЕГН</label>
				<input type="number" name="egn" class="form-control" value="<?php echo $egn; ?>" placeholder="ЕГН на ученика">
			</div>
			<div class="form-group">
				<label>Име</label>
				<input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>" placeholder="Име на ученика">
			</div>
			<div class="form-group">
				<label>Презиме</label>
				<input type="text" name="second_name" class="form-control" value="<?php echo $second_name; ?>" placeholder="Презиме на ученика">
			</div>
			<div class="form-group">
				<label>Фамилия</label>
				<input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>" placeholder="Фамилия на ученика">
			</div>
			<div class="form-group">
				<label>Номер в клас</label>
				<input type="number" min="1" name="class_no" class="form-control" value="<?php echo $class_no; ?>" placeholder="Номер в клас">
			</div>
			<div class="form-group">
				<select name="class" class="form-control">
				  <option value="0">Клас</option>
				  <?php echo createOptions("classes_with_label"); ?>
				</select>
			</div>
			<div class="form-group">
				<label>Потребителско име</label>
				<input type="text" name="username" class="form-control" value="<?php echo $username_input; ?>" placeholder="Потребителско име за вход в системата">
			</div>
			<div class="form-group">
				<label>Парола</label>
				<input type="text" name="password" class="form-control" placeholder="Парола за достъп до системата">
			</div>
			<div class="form-group">
				<label>Описание</label>
				<textarea class="form-control" rows="4" maxlength="500" name="description" placeholder="Телефон, Адрес, ..."><?php echo $description; ?></textarea>
			</div>
			
			<?php if(isset($_GET["edit"])){ ?>
				<button type="submit" name="edit_student" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Редактирай</button>
				<a href="students.php" class="btn btn-default">Отказ</a>
			<?php } else if(isset($_GET["delete"])){ ?>
				<button type="submit" name="delete_student" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Изтрий</button>
				<a href="students.php" class="btn btn-default">Отказ</a>
			<?php } else { ?>
				<button type="submit" name="submit_student" id="submit" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-open"></span> Въведи</button>
				<a href="students.php" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Виж всички</a>
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