<?php 
	include("db_config.php");
	session_start();
?>
<?php
$username="";
$password="";
$role="";

if (isset($_POST["login"])) {
	$input_errors = array(); // масив, в който ще пазим грешките от празни input полета
	$input_success = array(); // масив, в който ще пазим успехите от input
	
	$username = $_POST["username"];
	$password = $_POST["password"];
	
	if (empty($username) || empty($password)) {
		array_push($input_errors, "Моля полълнете всички полета");
	}
	
	if(count($input_errors) == 0){
		$query_students = "SELECT * FROM students_view WHERE username='$username' AND password='$password'";
		$students = $db_sms->query($query_students);
		$students = mysqli_fetch_array($students);
		
		if ($students["username"] == $username && $students["password"] == $password) {
			$role = get_Role_By_Id($students["role_id"]);
			$_SESSION["egn"] = $students["egn"];
			$_SESSION["first_name"] = $students["first_name"];
			$_SESSION["second_name"] = $students["second_name"];
			$_SESSION["last_name"] = $students["last_name"];
			$_SESSION["class_no"] = $students["class_no"];
			$_SESSION["class"] = $students["class"];
			$_SESSION["class_teacher"] = $students["class_teacher"];
		}
		
		$query_teachers = "SELECT * FROM teachers WHERE username='$username' AND password='$password' AND role_id=3";
		$teachers = $db_sms->query($query_teachers);
		$teachers = mysqli_fetch_array($teachers);
		if ($teachers["username"] == $username && $teachers["password"] == $password) {
			$role = get_Role_By_Id($teachers["role_id"]);
			$_SESSION["id"] = $teachers["id"];
			$_SESSION["first_name"] = $teachers["first_name"];
			$_SESSION["last_name"] = $teachers["last_name"];
		}
		
		$query_class_teachers = "SELECT * FROM teachers WHERE username='$username' AND password='$password' AND role_id=2";
		$class_teachers = $db_sms->query($query_class_teachers);
		$class_teachers = mysqli_fetch_array($class_teachers);
		if ($class_teachers["username"] == $username && $class_teachers["password"] == $password) {
			$role = get_Role_By_Id($class_teachers["role_id"]);
			$_SESSION["id"] = $class_teachers["id"];
			$_SESSION["first_name"] = $class_teachers["first_name"];
			$_SESSION["last_name"] = $class_teachers["last_name"];
			$_SESSION["class"] = get_class_by_teacher_id($class_teachers["id"]);
		}

		$query_admin = "SELECT * FROM administrator WHERE username='$username'";
		$admin = $db_sms->query($query_admin);
		$admin = mysqli_fetch_array($admin);
		if ($admin["username"] == $username && (password_verify($password, $admin["password"]) || ($admin["password"] == "password" && $password == "password" ))) {
			$role = get_Role_By_Id($admin["role_id"]);
		}
		
		if ($role != "") {
			$_SESSION["username"] = $username;
			$_SESSION["role"] = $role;
		} else {
			array_push($input_errors, "Невалидно потребителско име или парола");
		}
	}
}

if (isset($_GET["logout"])) {
	session_destroy();
	session_unset();
	header("location: index.php");
}

// връща ролята, отговаряща на някакво id
function get_Role_By_Id($id){
	$query = "SELECT * FROM roles WHERE id=".$id;
	$role = $GLOBALS['db_sms']->query($query);
	$role = mysqli_fetch_array($role);
	$role = $role['role'];
	return $role;
}


// връща клас по id на класен ръководител
function get_class_by_teacher_id($id) {
	$query = "SELECT * FROM classes WHERE class_teacher_id=".$id;
	$class = $GLOBALS["db_sms"]->query($query);
	$class = mysqli_fetch_array($class);
	$class = $class["class"] . " " . $class["class_section"];
	return($class);
}

?>