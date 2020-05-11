<?php
include("db_config.php");
include("create_options.php");
include("get_by_functions.php");
?>

<?php
$input_errors = array(); // масив, в който ще пазим грешките от празни input полета
$input_success = array(); // масив, в който ще пазим успехите от input

$student_egn = "";
$subject_id = 0;
$grade_id = 0;
$term_id = 0;

// когато се натисне бутона за записване
if (isset($_POST["submit_term_grade"])) { 
	$student_egn = $_POST['student_egn'];
	$subject_id = $_POST['subject_id'];
	$grade_id = $_POST['grade_id'];
	$term_id = get_term_now("number");
	$teacher_id = $_SESSION['id'];
	$class = get_class_by_egn($student_egn);
	
	if(empty($student_egn) || $subject_id == 0 || $grade_id == 0) {
		array_push($input_errors, "Моля попълнете всички полета!");
		return;
	}
	
	$query = "INSERT INTO term_grades VALUES ('$student_egn', '$subject_id', '$grade_id', '$term_id', '$class', '$teacher_id')";
	if ($db_sms->query($query)) {
		array_push($input_success, "Записът беше успешно вмъкнат в базата данни.");
		$student_egn = "";
		$subject_id = 0;
		$grade_id = 0;
		$term_id = 0;
	} else {
		array_push($input_errors, "Проблем при вмъкването на записа в базата данни!");
	}
}

// когато се натисне бутона за редактиране
if (isset($_POST["edit_term_grade"])) {
	$student_egn = $_POST['student_egn'];
	$subject_id = $_POST['subject_id'];
	$grade_id = $_POST['grade_id'];
	$term_id = get_term_now("number");
	
	$old_student_egn = $_COOKIE["old_student_egn"];
	$old_subject_id = $_COOKIE["old_subject_id"];
	$old_grade_id = $_COOKIE["old_grade_id"];
	
	setcookie("old_student_egn", "", time() - 3600); // унищожаваме бисквитката
	setcookie("old_subject_id", "", time() - 3600); // унищожаваме бисквитката
	setcookie("old_grade_id", "", time() - 3600); // унищожаваме бисквитката
	
	if(empty($student_egn) || $subject_id == 0 || $grade_id == 0) {
		header("location: term_grades_input.php?edit=1&student_egn=". $old_student_egn ."&subject_id=". $old_subject_id ."&grade_id=". $old_grade_id ."&error=1");
		return;
	}

	$query = "UPDATE term_grades SET student_egn='$student_egn', subject_id='$subject_id', grade_id='$grade_id' WHERE student_egn='$old_student_egn' AND subject_id='$old_subject_id' AND grade_id='$old_grade_id' AND term_id='".$term_id."'";
	
	if ($db_sms->query($query) && mysqli_affected_rows($db_sms)>0) {
		header("location: term_grades.php?success=3");
	} else {
		header("location: term_grades.php?error=3");
	}
}

// когато се натисне бутона за изтриване
if (isset($_POST["delete_term_grade"])) {
	$student_egn = $_POST['student_egn'];
	$subject_id = $_POST['subject_id'];
	$grade_id = $_POST['grade_id'];
	$term_id = get_term_now("number");
	
	$query = "DELETE FROM term_grades WHERE student_egn='".$student_egn."' AND subject_id='".$subject_id."' AND grade_id='".$grade_id."' AND term_id='".$term_id."'";
	if ($db_sms->query($query) && mysqli_affected_rows($db_sms)>0) {
		header("location: term_grades.php?success=4");
	} else {
		header("location: term_grades.php?error=4");
	}
}

// обновява таблицата с CRUD
function refresh_term_grades_table() {
	if (isset($_SESSION["egn"])) {
		$query = "SELECT * FROM term_grades_view WHERE student_egn=".$_SESSION["egn"]." ORDER BY for_class, class_now, term_id, class_no, subject";
	} else
	if ($_SESSION["role"] === "class teacher") {
		$query = "SELECT * FROM term_grades_view WHERE class_now='".$_SESSION["class"]."' OR teacher_id=".$_SESSION["id"]." ORDER BY for_class, class_now, term_id, class_no, subject";
	} else
	if ($_SESSION["role"] === "teacher") {
		$query = "SELECT * FROM term_grades_view WHERE teacher_id=".$_SESSION["id"]." ORDER BY for_class, class_now, term_id, class_no, subject";
	} else {
		$query = "SELECT * FROM term_grades_view WHERE 1 ORDER BY for_class, class_now, term_id, class_no, subject";
	}
	
	$rows = $GLOBALS["db_sms"]->query($query);
	
	while($row = mysqli_fetch_array($rows)) {
		echo '
			<tr>
			  <td>'. $row["student_name"] .'</td>
			  <td>'. $row["class_no"] .'</td>
			  <td class="Class_now">'. $row["class_now"] .'</td>
			  <td>'. $row["subject"] .'</td>
			  <td class="grade">'. $row["grade"] .'</td>
			  <td class="Term">'. $row["term_label"] .'</td>
			  <td class="For_class">'. $row["for_class"] .'</td>
			  <td>'. $row["teacher"] .'</td>
		';
		if ($_SESSION["role"] === "teacher" || $_SESSION["role"] === "class teacher" && get_term_now("number") == $row["term_id"] && explode(" ", $row["class_now"])[0] == $row["for_class"]) {
			echo '
			  <td>
				<a href="term_grades_input.php?edit=1&student_egn='. $row["student_egn"] .'&subject_id='. $row["subject_id"] .'&grade_id='. $row["grade_id"] .'"><span class="glyphicon glyphicon-pencil" title="Редактиране"></span></a>
				<a href="term_grades_input.php?delete=1&student_egn='. $row["student_egn"] .'&subject_id='. $row["subject_id"] .'&grade_id='. $row["grade_id"] .'"><span class="glyphicon glyphicon-trash" title="Изтриване"></span></a>
			  </td>
			';
		} else
		if ($_SESSION["role"] === "teacher" || $_SESSION["role"] === "class teacher") {
			echo '
			  <td>
				<span class="glyphicon glyphicon-ban-circle" title="Забранено"></span>
			  </td>
			';
		} 
		//else
		//if ( $_SESSION["role"] != "administrator" ) {
		//	echo '<td></td>';
		//}
		
		echo '</tr>';
    }
}

?>