<?php
include("db_config.php");
include("create_options.php");
?>

<?php
$input_errors = array(); // масив, в който ще пазим грешките от празни input полета
$input_success = array(); // масив, в който ще пазим успехите от input

$egn = "";
$first_name = "";
$second_name = "";
$last_name = "";
$class_no = "";
$class_id = 0;
$description = "";
$username_input= "";

// когато се натисне бутона за записване
if (isset($_POST["submit_student"])) { 
	$egn = trim($_POST["egn"]);
	$first_name = trim($_POST["first_name"]);
	$second_name = trim($_POST["second_name"]);
	$last_name = trim($_POST["last_name"]);
	$class_no = trim($_POST["class_no"]);
	$class_id = $_POST["class"];
	$description = trim($_POST["description"]);
	$username_input= trim($_POST["username"]);
	$password= $_POST["password"];
	
	if(empty($egn) || empty($first_name) || empty($second_name) || empty($last_name) || empty($class_no) || $class_id == 0 || empty($username_input) || empty($password)) {
		array_push($input_errors, "Моля попълнете всички полета!");
		return;
	}
	
	if(strlen($egn)!= 10) {
		array_push($input_errors, "ЕГН трябва да е 10 символа");
		return;
	}
	
	
	$query_check_teachers = "SELECT username FROM teachers WHERE username='$username_input'";
	$query_check_students = "SELECT username FROM students WHERE username='$username_input'";
	if ($username_input == "administrator" || mysqli_num_rows($db_sms->query($query_check_teachers)) > 0 || mysqli_num_rows($db_sms->query($query_check_students)) > 0) {
		array_push($input_errors, "Потребителското име е заето");
		return;
	}
	
	$query = "INSERT INTO students VALUES ('$egn', '$first_name', '$second_name', '$last_name', '$class_no', '$class_id', '$description', '$username_input', '$password', 4)";
	if ($db_sms->query($query)) {
		array_push($input_success, "Записът беше успешно вмъкнат в базата данни.");
		$egn = "";
		$first_name = "";
		$second_name = "";
		$last_name = "";
		$class_no = "";
		$class_id = 0;
		$description = "";
		$username_input= "";
	} else {
		array_push($input_errors, "Проблем при вмъкването на записа в базата данни!");
	}
}

// когато се натисне бутона за редактиране
if (isset($_POST["edit_student"])) {
	$egn = trim($_POST["egn"]);
	$first_name = trim($_POST["first_name"]);
	$second_name = trim($_POST["second_name"]);
	$last_name = trim($_POST["last_name"]);
	$class_no = trim($_POST["class_no"]);
	$class_id = $_POST["class"];
	$description = trim($_POST["description"]); // взимаме и новите редове
	$username_input= trim($_POST["username"]);
	$password= $_POST["password"];
	
	$old_egn = $_COOKIE["old_egn"];
	$old_first_name = $_COOKIE["old_first_name"];
	$old_second_name = $_COOKIE["old_second_name"];
	$old_last_name = $_COOKIE["old_last_name"];
	$old_class_no = $_COOKIE["old_class_no"];
	$old_class_id = $_COOKIE["old_class_id"];
	$old_username_input = $_COOKIE["old_username_input"];
	
	setcookie("old_egn", "", time() - 3600); // унищожаваме бисквитката
	setcookie("old_first_name", "", time() - 3600); // унищожаваме бисквитката
	setcookie("old_second_name", "", time() - 3600); // унищожаваме бисквитката
	setcookie("old_last_name", "", time() - 3600); // унищожаваме бисквитката
	setcookie("old_class_no", "", time() - 3600); // унищожаваме бисквитката
	setcookie("old_class_id", "", time() - 3600); // унищожаваме бисквитката
	setcookie("old_username_input", "", time() - 3600); // унищожаваме бисквитката
	
	if(empty($egn) || empty($first_name) || empty($second_name) || empty($last_name) || empty($class_no) || $class_id == 0 || empty($username_input)) {
		header("location: ?edit=1&egn=".$old_egn."&error=1");
		return;
	}
	
	if(strlen($egn)!= 10) {
		header("location: ?edit=1&egn=".$old_egn."&error=2");
		return;
	}
	
	if(!empty($password)) {
		$query = "UPDATE students SET egn='$egn', first_name='$first_name', second_name='$second_name', last_name='$last_name', class_no='$class_no', class_id='$class_id', description='$description', username='$username_input', password='$password' WHERE egn='$old_egn' AND first_name='$old_first_name' AND second_name='$old_second_name' AND last_name='$old_last_name' AND class_no='$old_class_no' AND class_id='$old_class_id' AND username='$old_username_input'";
	} else {
		$query = "UPDATE students SET egn='$egn', first_name='$first_name', second_name='$second_name', last_name='$last_name', class_no='$class_no', class_id='$class_id', description='$description', username='$username_input' WHERE first_name='$old_first_name' AND second_name='$old_second_name' AND last_name='$old_last_name' AND class_no='$old_class_no' AND class_id='$old_class_id' AND username='$old_username_input'";
	}
	
	if ($db_sms->query($query)) {
		header("location: students.php?success=3");
	} else {
		header("location: students.php?error=3");
	}
}

// когато се натисне бутона за изтриване
if (isset($_POST["delete_student"])) {
	$egn = trim($_POST["egn"]);
	$first_name = trim($_POST["first_name"]);
	$second_name = trim($_POST["second_name"]);
	$last_name = trim($_POST["last_name"]);
	$class_no = trim($_POST["class_no"]);
	$class_id = $_POST["class"];
	$description = trim($_POST["description"]);
	$username_input= trim($_POST["username"]);
	$password= $_POST["password"];
	
	$query = "DELETE FROM students WHERE egn='". $egn . "' AND first_name='". $first_name ."' AND last_name='".$last_name."' AND class_no='". $class_no ."' AND class_id='". $class_id ."' AND username='". $username_input ."'";
	if ($db_sms->query($query) && mysqli_affected_rows($db_sms)>0) {
		header("location: students.php?success=4");
	} else {
		header("location: students.php?error=4");
	}
}

// обновява таблицата с CRUD
function refresh_students_table() {
	if (isset($_SESSION["id"])) {
		$query = "SELECT * FROM students_view WHERE class_teacher_id=".$_SESSION["id"]." ORDER BY class, class_no";
	} else {
		$query = "SELECT * FROM students_view WHERE 1 ORDER BY class, class_no";
	}
	$rows = $GLOBALS["db_sms"]->query($query);
	
	while($row = mysqli_fetch_array($rows)) {
		echo '
		<tr data-toggle="modal" data-target="#studentDescriptionModal'. $row["egn"] .'">
			<td>'. $row["egn"] .'</td>
			<td>'. $row["first_name"] .'</td>
			<td>'. $row["second_name"] .'</td>
			<td>'. $row["last_name"] .'</td>
			<td>'. $row["class_no"] .'</td>
			<td class="Class_now">'. $row["class"] .'</td>
			<td> 
				<a href="students_input.php?edit=1&egn='. $row["egn"] .'"><span class="glyphicon glyphicon-pencil" title="Редактиране"></span></a>
				<a href="students_input.php?delete=1&egn='. $row["egn"] .'"><span class="glyphicon glyphicon-trash" title="Изтриване"></span></a>
			</td>
		</tr>
		';
		
		echo '
		<div class="modal fade" id="studentDescriptionModal'.$row["egn"].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">'. $row["first_name"] .' '. $row["second_name"] .' '. $row["last_name"] .'</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">				
				<pre>
				<b>Име:</b> '. $row["first_name"] .'
				<b>Презиме:</b> '. $row["second_name"] .'
				<b>Фамилия:</b> '. $row["last_name"] .'
				<b>ЕГН:</b> '. $row["egn"] .'
				<b>Номер в клас:</b> '. $row["class_no"] .'
				<b>Клас:</b> '. $row["class"] .'
				<b>Потребителско име:</b> '. $row["username"] .'
				<b>Описание:</b>
				'. $row["description"] .'
				</pre>
			  </div>
			  <div class="modal-footer">
			    <a href="students_input.php?edit=1&egn='. $row["egn"] .'" class="btn btn-warning"><span class="glyphicon glyphicon-pencil"></span> Редактирай</a>
				<a href="students_input.php?delete=1&egn='. $row["egn"] .'" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Изтрий</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
			  </div>
			</div>
		  </div>
		</div>
		';
    }
}

?>