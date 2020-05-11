<?php
include("db_config.php");
include("create_options.php");
?>

<?php
$input_errors = array(); // масив, в който ще пазим грешките от празни input полета
$input_success = array(); // масив, в който ще пазим успехите от input

$class_id=0;
$teacher_id=0;

// когато се натисне бутона за записване
if (isset($_POST["submit_class_teacher"])) { 
	$class = $_POST["class"];
	$teacher = $_POST["teacher"];
	
	if($class == 0 || $teacher == 0) {
		array_push($input_errors, "Моля попълнете всички полета!");
		// за да върнем избраните стойности
		$class_id = $_POST["class"];
		$teacher_id = $_POST["teacher"];
		return;
	}
	
	$query = "INSERT INTO class_teachers VALUES ('$class', '$teacher')";
	if ($db_sms->query($query)) {
		array_push($input_success, "Записът беше успешно вмъкнат в базата данни.");
		$class_id=0;
		$teacher_id=0;
	} else {
		array_push($input_errors, "Проблем при вмъкването на записа в базата данни!");
	}
}

// когато се натисне бутона за редактиране
if (isset($_POST["edit_class_teacher"])) {
	$class = $_POST["class"];
	$teacher = $_POST["teacher"];
	$old_class = $_COOKIE["old_class"];
	$old_teacher = $_COOKIE["old_teacher"];
	setcookie("old_class", "", time() - 3600); // унищожаваме бисквитката
	setcookie("old_teacher", "", time() - 3600); // унищожаваме бисквитката
	
	if($class == 0 || $teacher == 0) {
		array_push($input_errors, "Моля попълнете всички полета!");
		return;
	}
	
	$query = "UPDATE class_teachers SET class_id='$class', teacher_id='$teacher' WHERE class_id='$old_class' AND teacher_id = '$old_teacher'";
	
	if ($db_sms->query($query)) {
		header("location: class_teachers.php?success=3");
	} else {
		header("location: class_teachers.php?error=3");
	}
}

// когато се натисне бутона за изтриване
if (isset($_POST["delete_class_teacher"])) {
	$class = $_POST["class"];
	$teacher = $_POST["teacher"];
	
	$query = "DELETE FROM class_teachers WHERE class_id=". $class ." AND teacher_id='". $teacher."'";
	if ($db_sms->query($query) && mysqli_affected_rows($db_sms)>0) {
		header("location: class_teachers.php?success=4");
	} else {
		header("location: class_teachers.php?error=4");
	}
}

// обновява таблицата с CRUD
function refresh_class_teachers_table() {
	$query = "SELECT * FROM class_teachers_view WHERE 1 ORDER BY class, teacher";
	$rows = $GLOBALS["db_sms"]->query($query);
	
	while($row = mysqli_fetch_array($rows)) {
		echo '
		<tr>
		  <td>'. $row["class"] .'</td>
		  <td>'. $row["teacher"] .'</td>
		  <td>
			<a href="class_teachers_input.php?edit=1&class='. $row["class_id"] .'&teacher='. $row["teacher_id"] .'"><span class="glyphicon glyphicon-pencil" title="Редактиране"></span></a> 
			<a href="class_teachers_input.php?delete=1&class='. $row["class_id"] .'&teacher='. $row["teacher_id"] .'"><span class="glyphicon glyphicon-trash" title="Изтриване"></span></a>
		</td>
		</tr>
		';
    }
}

?>