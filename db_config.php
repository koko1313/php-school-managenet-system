<?php
$server = "localhost";
$user = "root";
$password = "";

$conn = mysqli_connect($server, $user, $password);
$db_sms = mysqli_connect($server, $user, $password, "school_management_system");

mysqli_set_charset($conn,"utf8");
mysqli_set_charset($db_sms,"utf8");
?>

<?php

$query = "SELECT * FROM school WHERE 1";
$school = $db_sms->query($query);
$school = mysqli_fetch_array($school);
$school_name = $school["name"];
$school_description = $school["description"];
?>