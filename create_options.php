<?php 
function createOptions($table) {
	$options="";
	if ($table=="teachers") {
		$query = "SELECT * FROM teachers WHERE 1 ORDER BY first_name, last_name";
		$rows = $GLOBALS["db_sms"]->query($query);
		while ($row = mysqli_fetch_array($rows)) {
			$selected = "";
			if($row['id'] == $GLOBALS['teacher_id']) $selected = ' selected';
			$options .= "<option value='". $row["id"] ."'". $selected .">". $row["first_name"] ." ". $row["last_name"] ."</option>";
		}
	} else
	if ($table=="students") {
		if (isset($_COOKIE["students_filter_by_class"]) && $_COOKIE["students_filter_by_class"] != 0) {
			$query = "SELECT * FROM students_teachers_view WHERE teacher_id=". $_SESSION["id"] ." AND class_id=".$_COOKIE["students_filter_by_class"]." ORDER BY class, class_no";
		} else {
			$query = "SELECT * FROM students_teachers_view WHERE teacher_id=".$_SESSION["id"]." ORDER BY class, class_no";
		}
		
		$rows = $GLOBALS["db_sms"]->query($query);
		while ($row = mysqli_fetch_array($rows)) {
			$selected = "";
			if($row['egn'] == $GLOBALS['student_egn']) $selected = ' selected';
			$options .= "<option value='". $row["egn"] ."' id='". $row["class"] ."'" . $selected .">". $row["class_no"] ." - ". $row["student_name"] ."</option>";
		}
	} else
	if ($table=="subjects") {
		if (isset($_SESSION["id"])) {
			$query = "SELECT * FROM teachers_subjects_view WHERE teacher_id=".$_SESSION["id"]." ORDER BY subject";
		} else {
			$query = "SELECT * FROM teachers_subjects_view WHERE 1 ORDER BY subject";
		}
		
		if ($_SESSION["role"] === "administrator") {
			$query = "SELECT * FROM subjects WHERE 1 ORDER BY subject";
		}
		
		$rows = $GLOBALS["db_sms"]->query($query);
		while ($row = mysqli_fetch_array($rows)) {
			$selected = "";
			if ($_SESSION["role"] === "administrator") {
				if($row['id'] == $GLOBALS['subject_id']) $selected = ' selected';
				$options .= "<option value='". $row["id"] ."'". $selected .">". $row["subject"] ."</option>";
			} else {
				if($row['subject_id'] == $GLOBALS['subject_id']) $selected = ' selected';
				$options .= "<option value='". $row["subject_id"] ."'". $selected .">". $row["subject"] ."</option>";
			}
		}
	} else
	if ($table=="grades") {
		$query = "SELECT * FROM grades WHERE 1";
		$rows = $GLOBALS["db_sms"]->query($query);
		while ($row = mysqli_fetch_array($rows)) {
			$selected = "";
			if($row['id'] == $GLOBALS['grade_id']) $selected = ' selected';
			$options .= "<option value='". $row["id"] ."'". $selected .">". $row["grade_label"] ." ". $row["grade"] ."</option>";
		}
	} else
	if ($table=="terms") {
		$query = "SELECT * FROM terms WHERE 1";
		$rows = $GLOBALS["db_sms"]->query($query);
		while ($row = mysqli_fetch_array($rows)) {
			$selected = "";
			if($row['id'] == $GLOBALS['term_id']) $selected = ' selected';
			$options .= "<option value='". $row["id"] ."'". $selected .">". $row["term_label"] ."</option>";
		}
	} else
	if ($table=="classes") {
		$query = "SELECT * FROM classes WHERE 1 ORDER BY class";
		$rows = $GLOBALS["db_sms"]->query($query);
		while ($row = mysqli_fetch_array($rows)) {
			$selected = "";
			if($row['id'] == $GLOBALS['class_id']) $selected = ' selected';
			$options .= "<option value='". $row["id"] ."'". $selected .">". $row["class"] ."</option>";
		}
	} else
	if ($table=="classes_with_label") {
		if (isset($_SESSION["id"])) {
			$query = "SELECT * FROM classes WHERE class_teacher_id=".$_SESSION["id"]." ORDER BY class";
		} else {
			$query = "SELECT * FROM classes WHERE 1 ORDER BY class";
		}
		
		$rows = $GLOBALS["db_sms"]->query($query);
		while ($row = mysqli_fetch_array($rows)) {
			$selected = "";
			if($row['id'] == $GLOBALS['class_id']) $selected = ' selected';
			$options .= "<option value='". $row["id"] ."'". $selected .">". $row["class"] . " " . $row["class_section"] ."</option>";
		}
	} else	
	if ($table=="classes_as_text") {
		$query = "SELECT * FROM classes WHERE 1 GROUP BY class ORDER BY class";
		
		$rows = $GLOBALS["db_sms"]->query($query);
		while ($row = mysqli_fetch_array($rows)) {
			$selected = "";
			if(isset($GLOBALS['for_class'])) {
				if($row['class'] == $GLOBALS['for_class']) $selected = ' selected';
			}
			$options .= "<option id='".$row["class"]."' ". $selected .">". $row["class"] ."</option>";
		}
	} else
	if ($table=="students_filter_by_class") {
		if ($_SESSION["role"] === "administrator") {
			$query = "SELECT * FROM students_teachers_view WHERE 1 GROUP BY class_id ORDER BY class";
		} else {
			$query = "SELECT * FROM students_teachers_view WHERE teacher_id=".$_SESSION["id"]." GROUP BY class_id ORDER BY class";
		}
		
		$rows = $GLOBALS["db_sms"]->query($query);
		while ($row = mysqli_fetch_array($rows)) {
			$options .= "<option value='". $row["class_id"] ."'>". $row["class"] ."</option>";
		}
	}
	return $options;
}
?>