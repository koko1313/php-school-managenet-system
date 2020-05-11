<?php 
	include("students_io.php");
	include("user_session_control.php");
	if (empty($_SESSION["username"]) || !($_SESSION["role"] === "administrator" || $_SESSION["role"] === "class teacher") ) header("location: index.php");
	$page_now="students";
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
			<h2>Ученици</h2>
			<a href="students_input.php">Въвеждане на нов ученик</a>
		</div>

		<div class="col-md-10">
			<?php include("table_filter.php"); ?>
			
			<?php include("errors_success_messages.php"); ?>
			<table id="filteredTable" class="table-mobile table-mobile-students table table-striped table-hover table-hover-pointer">
				<thead>
				<tr>
					<th scope="col">ЕГН</th>
					<th scope="col">Име</th>
					<th scope="col">Презиме</th>
					<th scope="col">Фамилия</th>
					<th scope="col">Номер в клас</th>
					<th scope="col">Клас</th>
					<th scope="col">Действие</th>
				</tr>
				</thead>
				<tbody>
					<?php refresh_students_table(); ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php include("footer.php"); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="scripts/filterScript.js"></script>

</body>
</html>