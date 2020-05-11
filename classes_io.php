<?php
include("db_config.php");
include("create_options.php");
?>

<?php
$input_errors = array(); // масив, в който ще пазим грешките от празни input полета
$input_success = array(); // масив, в който ще пазим успехите от input

$class = "";
$class_section = "";
$teacher_id = 0;

// когато се натисне бутона за записване
if (isset($_POST["submit_class"])) { 
	$class = trim($_POST["class"]);
	$class_section = trim($_POST["class_section"]);
	$teacher_id = $_POST["teacher"];
	
	if(empty($class) || empty($class_section) || $teacher_id==0) {
		array_push($input_errors, "Моля попълнете всички полета!");
		return;
	}
	
	$query = "INSERT INTO classes VALUES (Null, '$class', UPPER('$class_section'), '$teacher_id')";
	
	$query_change_role_to_class_teacher_id = "UPDATE teachers SET role_id=2 WHERE id=".$teacher_id;
	
	if ($db_sms->query($query)) {
		array_push($input_success, "Записът беше успешно вмъкнат в базата данни.");
		$db_sms->query($query_change_role_to_class_teacher_id); // правим ролята class teacher
		$class = "";
		$class_section = "";
		$teacher_id = 0;
	} else {
		array_push($input_errors, "Проблем при вмъкването на записа в базата данни!");
	}
}

// когато се натисне бутона за редактиране
if (isset($_POST["edit_class"])) {
	$class = trim($_POST["class"]);
	$class_section = trim($_POST["class_section"]);
	$teacher_id = $_POST["teacher"];
	
	$old_class = $_COOKIE["old_class"];
	$old_class_section = $_COOKIE["old_class_section"];
	$old_teacher_id = $_COOKIE["old_teacher"];
	
	if(empty($class) || empty($class_section) || $teacher_id==0) {
		header("location: classes_input.php?edit=1&class=". $old_class ."&class_section=". $old_class_section ."&class_teacher_id=". $old_teacher_id."&error=1");
		return;
	}
	
	$query = "UPDATE classes SET class='$class', class_section=UPPER('$class_section'), class_teacher_id='$teacher_id' WHERE class='$old_class' AND class_section='$old_class_section' AND class_teacher_id='$old_teacher_id'";
	
	echo $query;
	
	$query_change_role_to_teacher = "UPDATE teachers SET role_id=3 WHERE id=".$old_teacher_id;
	$query_change_role_to_class_teacher = "UPDATE teachers SET role_id=2 WHERE id=".$teacher_id;
	
	if ($db_sms->query($query)) {
		$db_sms->query($query_change_role_to_teacher);
		$db_sms->query($query_change_role_to_class_teacher);
		header("location: classes.php?success=3");
	} else {
		header("location: classes.php?error=3");
	}
}

// когато се натисне бутона за изтриване
if (isset($_POST["delete_class"])) {
	$class = trim($_POST["class"]);
	$class_section = trim($_POST["class_section"]);
	$teacher_id = $_POST["teacher"];
	
	$query = "DELETE FROM classes WHERE class='$class' AND class_section='$class_section' AND class_teacher_id='$teacher_id'";
	
	$query_change_role_to_teacher = "UPDATE teachers SET role_id=3 WHERE id=".$teacher_id;
	
	if ($db_sms->query($query) && mysqli_affected_rows($db_sms)>0) {
		$db_sms->query($query_change_role_to_teacher);
		header("location: classes.php?success=4");
	} else {
		header("location: classes.php?error=4");
	}
}

// обновява таблицата с CRUD
function refresh_classes_table() {
	$query = "SELECT * FROM classes_view WHERE 1 ORDER BY class, class_section";
	$rows = $GLOBALS["db_sms"]->query($query);
	
	while($row = mysqli_fetch_array($rows)) {
		echo '
		<tr>
		  <td>'. $row["class"] .'</td>
		  <td>'. $row["class_section"] .'</td>
		  <td>'. $row["class_teacher"] .'</td>
		  <td>
			<a href="classes_input.php?edit=1&class='. $row["class"] .'&class_section='. $row["class_section"] .'&class_teacher_id='. $row["class_teacher_id"] .'"><span class="glyphicon glyphicon-pencil" title="Редактиране"></span></a>
			<a href="classes_input.php?delete=1&class='. $row["class"] .'&class_section='. $row["class_section"] .'&class_teacher_id='. $row["class_teacher_id"] .'"><span class="glyphicon glyphicon-trash" title="Изтриване"></span></a>
		</td>
		</tr>
		';
    }
}

?>