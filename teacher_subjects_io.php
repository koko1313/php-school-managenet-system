<?php
include("db_config.php");
include("create_options.php");
?>

<?php
$input_errors = array(); // масив, в който ще пазим грешките от празни input полета
$input_success = array(); // масив, в който ще пазим успехите от input

$teacher_id=0;
$subject_id=0;

// когато се натисне бутона за записване
if (isset($_POST["submit_teacher_subject"])) { 
	$subject = $_POST["subject"];
	$teacher = $_POST["teacher"];
	
	if($subject == 0 || $teacher == 0) {
		array_push($input_errors, "Моля попълнете всички полета!");
		// за да върнем избраните стойности
		$subject_id = $_POST["subject"];
		$teacher_id = $_POST["teacher"];
		return;
	}
	
	$query = "INSERT INTO teachers_subjects VALUES ('$teacher', '$subject')";
	if ($db_sms->query($query)) {
		array_push($input_success, "Записът беше успешно вмъкнат в базата данни.");
		$teacher_id=0;
		$subject_id=0;
	} else {
		array_push($input_errors, "Проблем при вмъкването на записа в базата данни!");
	}
}

// когато се натисне бутона за редактиране
if (isset($_POST["edit_teacher_subject"])) {
	$subject = $_POST["subject"];
	$teacher = $_POST["teacher"];
	$old_subject = $_COOKIE["old_subject"];
	$old_teacher = $_COOKIE["old_teacher"];
	setcookie("old_subject", "", time() - 3600); // унищожаваме бисквитката
	setcookie("old_teacher", "", time() - 3600); // унищожаваме бисквитката
	
	if($subject == 0 || $teacher == 0) {
		header("location: teacher_subjects_input.php?edit=1&subject=". $old_subject ."&teacher=". $old_teacher ."&error=1");
		return;
	}
	
	$query = "UPDATE teachers_subjects SET teacher_id='$teacher', subject_id='$subject' WHERE teacher_id='$old_teacher' AND subject_id = '$old_subject'";
	
	if ($db_sms->query($query)) {
		header("location: teacher_subjects.php?success=3");
	} else {
		header("location: teacher_subjects.php?error=3");
	}
}

// когато се натисне бутона за изтриване
if (isset($_POST["delete_teacher_subject"])) {
	$teacher = $_POST["teacher"];
	$subject = $_POST["subject"];
	
	$query = "DELETE FROM teachers_subjects WHERE teacher_id=". $teacher ." AND subject_id='". $subject."'";
	if ($db_sms->query($query) && mysqli_affected_rows($db_sms)>0) {
		header("location: teacher_subjects.php?success=4");
	} else {
		header("location: teacher_subjects.php?error=4");
	}
}

// обновява таблицата с CRUD
function refresh_teacher_subjects_table() {
	$query = "SELECT * FROM teachers_subjects_view WHERE 1 ORDER BY subject, teacher";
	$rows = $GLOBALS["db_sms"]->query($query);
	
	while($row = mysqli_fetch_array($rows)) {
		echo '
		<tr>
		  <td>'. $row["subject"] .'</td>
		  <td>'. $row["teacher"] .'</td>
		  <td>
			<a href="teacher_subjects_input.php?edit=1&subject='. $row["subject_id"] .'&teacher='. $row["teacher_id"] .'"><span class="glyphicon glyphicon-pencil" title="Редактиране"></span></a>
			<a href="teacher_subjects_input.php?delete=1&subject='. $row["subject_id"] .'&teacher='. $row["teacher_id"] .'"><span class="glyphicon glyphicon-trash" title="Изтриване"></span></a>
		</td>
		</tr>
		';
    }
}

?>