<?php 
	include("user_session_control.php");
	if (empty($_SESSION["username"])) header("location: index.php"); else
	if ( !($_SESSION["role"] === "teacher" || $_SESSION["role"] === "class teacher") ) header("location: current_grades.php");
	include("current_grades_io.php"); 
	$page_now="current_grades";
?>

<?php 
	if(isset($_GET["edit"]) || isset($_GET["delete"])) {
		$student_egn = $_GET["student_egn"];
		$subject_id = $_GET["subject_id"];
		$grade_id = $_GET["grade_id"];
		
		setCookie("old_student_egn", $student_egn);
		setCookie("old_subject_id", $subject_id);
		setCookie("old_grade_id", $grade_id);
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
<h2><strong><u>Вписване</u></strong> / Редактиране / Изтриване на оценка</h2>
<?php } else if (isset($_GET["edit"])) { ?>
<h2>Вписване / <strong><u>Редактиране</u></strong> / Изтриване на оценка</h2>
<?php } else if (isset($_GET["delete"])) { ?>
<h2>Вписване / Редактиране / <strong><u>Изтриване</u></strong> на оценка</h2>
<?php } ?>

<div class="container-fluid">
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<form method="post" name="form" action="current_grades_input.php">
			<?php include("errors_success_messages.php"); ?>
			<div class="form-group">
				<select name="students_filter_by_class" id="students_filter_by_class" class="form-control">
				  <option value="0">Филтрирай по клас</option>
				  <?php echo createOptions("students_filter_by_class"); ?>
				</select>
			</div>
			<div class="form-group">
				<select name="student_egn" class="form-control">
				  <option value="0">Ученик</option>
				  <?php echo createOptions("students"); ?>
				</select>
			</div>
			<div class="form-group">
				<select name="subject_id" class="form-control">
				  <option value="0">Предмет </option>
				  <?php echo createOptions("subjects"); ?>
				</select>
			</div>
			<div class="form-group">
				<label>Срок: <b><?php echo get_term_now("label"); ?></b></label>
			</div>
			<div class="form-group">
				<select name="grade_id" class="form-control">
				  <option value="0">Оценка</option>
				  <?php echo createOptions("grades"); ?>
				</select>
			</div>
			
			<?php if(isset($_GET["edit"])){ ?>
				<button type="submit" name="edit_current_grade" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Редактирай</button>
				<a href="current_grades.php" class="btn btn-default">Отказ</a>
			<?php } else if(isset($_GET["delete"])){ ?>
				<button type="submit" name="delete_current_grade" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Изтрий</button>
				<a href="current_grades.php" class="btn btn-default">Отказ</a>
			<?php } else { ?>
				<button type="submit" name="submit_current_grade" class="btn btn-primary"><span class="glyphicon glyphicon-floppy-open"></span> Въведи</button>
				<a href="current_grades.php" class="btn btn-default"><span class="glyphicon glyphicon-search"></span> Виж всички</a>
			<?php } ?>
		</form>
	</div>
</div>
</div>
	
<?php include("footer.php"); ?>	
	
<script src="scripts/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="scripts/bootstrap.min.js"></script>
<script src="scripts/script.js"></script>
</body>
</html>