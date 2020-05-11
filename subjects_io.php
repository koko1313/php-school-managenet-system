<?php
include("db_config.php");
?>

<?php
$input_errors = array(); // масив, в който ще пазим грешките от празни input полета
$input_success = array(); // масив, в който ще пазим успехите от input

$subject = "";

// когато се натисне бутона за записване на нов предмет
if (isset($_POST["submit_subject"])) { 
	$subject = trim($_POST["subject"]);
	
	if(empty($subject)) {
		array_push($input_errors, "Моля попълнете всички полета!");
		return;
	}
	
	$query = "INSERT INTO subjects VALUES (Null, '$subject')";
	if ($db_sms->query($query)) {
		$subject = "";
		array_push($input_success, "Предметът беше успешно вмъкнат в базата данни.");
	} else {
		array_push($input_errors, "Проблем при вмъкването на предмета в базата данни!");
	}
}

// когато се натисне бутона за редактиране на предмет
if (isset($_POST["edit_subject"])) {
	$subject = trim($_POST["subject"]);
	$old_subject = $_COOKIE["old_subject"];
	setcookie("old_subject", "", time() - 3600); // унищожаваме бисквитката
	
	if(empty($subject)) {
		header("location: subjects_input.php?edit=1&subject=".$old_subject."&error=1");
		return;
	}
	
	$query = "UPDATE subjects SET subject='$subject' WHERE subject = '$old_subject'";
	
	if ($db_sms->query($query)) {
		$subject = "";
		header("location: subjects.php?success=3");
	} else {
		header("location: subjects.php?error=3");
	}
}

// когато се натисне бутона за изтриване на предмет
if (isset($_POST["delete_subject"])) {
	$subject = trim($_POST["subject"]);
	
	$query = "DELETE FROM subjects WHERE subject='". $subject."'";
	if ($db_sms->query($query) && mysqli_affected_rows($db_sms)>0) {
		header("location: subjects.php?success=4");
	} else {
		header("location: subjects.php?error=4");
	}
}

// обновява таблицата с CRUD на учителите
function refresh_subjects_table() {
	$query = "SELECT subject FROM subjects WHERE 1 ORDER BY subject";
	$subjects = $GLOBALS["db_sms"]->query($query);
	
	while($subject = mysqli_fetch_array($subjects)) {
		echo '
		<tr>
		  <td>'. $subject["subject"] .'</td>
		  <td>
			<a href="subjects_input.php?edit=1&subject='. $subject["subject"] .'"><span class="glyphicon glyphicon-pencil" title="Редактиране"></span></a> 
			<a href="subjects_input.php?delete=1&subject='. $subject["subject"] .'"><span class="glyphicon glyphicon-trash" title="Изтриване"></span></a>
		</td>
		</tr>
		';
    }
}

?>