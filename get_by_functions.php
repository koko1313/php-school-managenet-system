<?php

function get_class_by_egn($egn){
	$query = "SELECT class FROM students_view WHERE egn='$egn'";
	$class = mysqli_fetch_array($GLOBALS["db_sms"]->query($query));
	$class = explode(" ",$class[0])[0];
	return $class;
}

function get_term_now($type){
	$query = "SELECT * FROM school_session_view WHERE now";
	$school_session = mysqli_fetch_array($GLOBALS["db_sms"]->query($query));
	if ($type == "number") $term_id = $school_session["term_id"]; else
	if ($type == "label") $term_id = $school_session["term_label"];
	return $term_id;
}

function get_class_teacher_id_by_egn($egn) {
	$query = "SELECT * FROM students_view WHERE egn=".$egn;
	$class_teacher = $GLOBALS["db_sms"]->query($query);
	$class_teacher = mysqli_fetch_array($class_teacher);
	$class_teacher = $class_teacher["class_teacher_id"];
	return $class_teacher;
}

?>