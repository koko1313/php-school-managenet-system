<?php 
	include("user_session_control.php");
	if (empty($_SESSION["username"])) header("location: index.php");
	include("session_grades_io.php");
	$page_now = "session_grades";
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
	<div class="col-md-2">
		<h2>Годишни оценки</h2>
		<?php if ($_SESSION["role"] === "teacher" || $_SESSION["role"] === "class teacher") { ?>
			<a href="session_grades_input.php" class="btn btn-link">Въвеждане на нова оценка</a>
		<?php } ?>
		<?php include("grades_statistic.php"); ?>
	</div>

	<div class="col-md-10">
		<?php include("table_filter.php"); ?>
		
		<?php include("errors_success_messages.php"); ?>
		
		<table id="filteredTable" class="table-mobile table-mobile-session table table-striped table-hover">
			<thead>
			<tr>
				<th scope="col">Ученик</th>
				<th scope="col">Номер в клас</th>
				<th scope="col">Клас</th>
				<th scope="col">Предмет</th>
				<th scope="col">Оценка</th>
				<th scope="col">За клас</th>
				<th scope="col">Добавена от</th>
				<?php if ($_SESSION["role"] === "teacher" || $_SESSION["role"] === "class teacher") { ?>
					<th scope="col">Действие</th>
				<?php } ?>
			</tr>
			</thead>
			<tbody>
				<?php refresh_session_grades_table(); ?>
			</tbody>
		</table>
	</div>
</div>
</div>

<?php include("footer.php"); ?>

<script src="scripts/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="scripts/bootstrap.min.js"></script>
<script src="scripts/filterScript.js"></script>
</body>
</html>