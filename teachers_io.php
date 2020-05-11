<?php
include("db_config.php");
?>

<?php
$input_errors = array(); // масив, в който ще пазим грешките от празни input полета
$input_success = array(); // масив, в който ще пазим успехите от input

$first_name = $last_name = $username_input = "";

// когато се натисне бутона за записване
if (isset($_POST["submit_teacher"])) { 
	$first_name = trim($_POST["first_name"]);
	$last_name = trim($_POST["last_name"]);
	$username_input = trim($_POST["username"]);
	$password = $_POST["password"];
	
	if(empty($first_name) || empty($last_name) || empty($username_input) || empty($password)) {
		array_push($input_errors, "Моля попълнете всички полета!");
		return;
	}
	
	$query_check_teachers = "SELECT username FROM teachers WHERE username='$username_input'";
	$query_check_students = "SELECT username FROM students WHERE username='$username_input'";
	if ($username_input == "administrator" || mysqli_num_rows($db_sms->query($query_check_teachers)) > 0 || mysqli_num_rows($db_sms->query($query_check_students)) > 0) {
		array_push($input_errors, "Потребителското име е заето");
		return;
	}
	
	$query = "INSERT INTO teachers VALUES (Null, '$first_name', '$last_name', '$username_input', '$password', 3)";
	if ($db_sms->query($query)) {
		array_push($input_success, "Учителят беше успешно вмъкнат в базата данни.");
		$first_name = $last_name = $username_input = "";
	} else {
		array_push($input_errors, "Проблем при вмъкването на учителя в базата данни!");
	}
}

// когато се натисне бутона за редактиране
if (isset($_POST["edit_teacher"])) {
	$first_name = trim($_POST["first_name"]);
	$last_name = trim($_POST["last_name"]);
	$username_input = trim($_POST["username"]);
	$password = $_POST["password"];
	$old_username_input = $_COOKIE["old_username_input"];
	setcookie("old_username_input", "", time() - 3600); // унищожаваме бисквитката
	
	if(empty($first_name) || empty($last_name) || empty($username_input)) {
		header("location: teachers_input.php?edit=1&first_name=". $first_name ."&last_name=". $last_name ."&username_input=". $old_username ."&error=1");
		return;
	}
	
	if(!empty($password)) {
		$query = "UPDATE teachers SET first_name='$first_name', last_name='$last_name', username='$username_input', password='$password' WHERE username = '$old_username_input'";
	} else {
		$query = "UPDATE teachers SET first_name='$first_name', last_name='$last_name', username='$username_input' WHERE username = '$old_username_input'";
	}
	
	if ($db_sms->query($query)) {
		header("location: teachers.php?success=3");
	} else {
		header("location: teachers.php?error=3");
	}
}

// когато се натисне бутона за изтриване
if (isset($_POST["delete_teacher"])) {
	$first_name = trim($_POST["first_name"]);
	$last_name = trim($_POST["last_name"]);
	$username_input = trim($_POST["username"]);
	
	$query = "DELETE FROM teachers WHERE first_name='". $first_name ."' AND last_name='". $last_name ."' AND username='". $username_input."'";
	
	echo $query;
	
	if ($db_sms->query($query) && mysqli_affected_rows($db_sms)>0) {
		header("location: teachers.php?success=4");
	} else {
		header("location: teachers.php?error=4");
	}
}

// обновява таблицата с CRUD на учителите
function refresh_teachers_table() {
	$query = "SELECT first_name, last_name, username FROM teachers WHERE 1 ORDER BY first_name, last_name";
	$teachers = $GLOBALS["db_sms"]->query($query);
	
	while($teacher = mysqli_fetch_array($teachers)) {
		echo '
		<tr>
		  <td>'. $teacher["first_name"] .'</td>
		  <td>'. $teacher["last_name"] .'</td>
		  <td>'. $teacher["username"] .'</td>
		  <td>
			<a href="teachers_input.php?edit=1&first_name='. $teacher["first_name"] .'&last_name='. $teacher["last_name"] .'&username_input='. $teacher["username"] .'"><span class="glyphicon glyphicon-pencil" title="Редактиране"></span></a> 
			<a href="teachers_input.php?delete=1&first_name='. $teacher["first_name"] .'&last_name='. $teacher["last_name"] .'&username_input='. $teacher["username"] .'"><span class="glyphicon glyphicon-trash" title="Изтриване"></span></a>
		  </td>
		</tr>
		';
    }
}

?>