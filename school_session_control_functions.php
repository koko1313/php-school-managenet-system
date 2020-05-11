<?php include("db_config.php"); ?>
<?php

$input_errors = array();
$input_success = array();

$query = "SELECT * FROM school_session_view WHERE now";
$school_session = mysqli_fetch_array($db_sms->query($query));
$term_id = $school_session["term_id"];

if (isset($_POST["change_school_session"])) {
	if($_POST["term"] != $term_id) {
		change_term($_POST["term"]);
	}
}

if (isset($_POST["increment_school_session"])) {
	$query = "UPDATE classes SET class=class+1";
	if ($db_sms->query($query) && mysqli_affected_rows($db_sms)>0) {
		array_push($input_success, "Промените бяха успешно записани");
		change_term(1);
		delete_finished_class();
	} else {
		array_push($input_errors, "Проблем при записването на промените");
	}
}

if (isset($_POST["change_school_details"])) {
	$name = $_POST["school_name"];
	$image = $_FILES["image"]["name"];
	$description = $_POST["school_description"];
	
	if (sizeof($name)==0 || sizeof($description)==0) {
		array_push($input_errors, "Моля попълнете всички полета");
	}
	
	$query = "UPDATE school SET name='$name', description='$description' WHERE 1";
	
	if ($db_sms->query($query)) {
		if (!empty($image)) {
			$temp = explode(".", $_FILES["image"]["name"]);
			if ($temp[1]!="jpg") {
				header("location: ?error=3");
			} else {
				$newfilename = "school_picture" . '.' . end($temp);
				move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $newfilename);
			}
		}
		header("location: ?success=3");
	} else {
		array_push($input_errors, "Проблем при правенето на промените");
	}
}

function change_term($term) {
	$query = "UPDATE school_session SET now=!now";
	if ($GLOBALS["db_sms"]->query($query)) {
		array_push($GLOBALS["input_success"], "Промените бяха успешно записани");
		$GLOBALS["term_id"] = $term;
	} else {
		array_push($GLOBALS["input_errors"], "Проблем при записването на промените");
	}		
}

function delete_finished_class() {
	$query = "DELETE FROM classes WHERE class>'12'";
	$GLOBALS["db_sms"]->query($query);
}

?>