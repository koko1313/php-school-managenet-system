<?php include("db_config.php"); ?>
<?php

function print_personal_information() {
	if($_SESSION["role"] === "student"){
		echo '
			<div class="personalInformation">
				<h2>Ученик</h2>
				<label>Име:</label> <span>'. $_SESSION["first_name"] .'</span> <br>
				<label>Презиме:</label> <span>'. $_SESSION["second_name"] .'</span> <br>
				<label>Фамилия:</label> <span>'. $_SESSION["last_name"] .'</span> <br>
				<label>Номер в клас:</label> <span>'. $_SESSION["class_no"] .'</span> <br>
				<label>Клас:</label> <span>'. $_SESSION["class"] .'</span> <br>
				<label>Класен ръководител:</label> <span>'. $_SESSION["class_teacher"] .'</span>
			</div>
		';
	} else
	if($_SESSION["role"] === "class teacher"){
		echo '
			<div class="personalInformation">
				<h2>Класен ръководител</h2>
				<label>Име:</label> <span>'. $_SESSION["first_name"] .'</span> <br>
				<label>Фамилия:</label> <span>'. $_SESSION["last_name"] .'</span> <br>
				<label>Клас:</label> <span>'. $_SESSION["class"] .'</span> <br>
			</div>
		';
	} else
	if($_SESSION["role"] === "teacher"){
		echo '
			<div class="personalInformation">
				<h2>Учител</h2>
				<label>Име:</label> <span>'. $_SESSION["first_name"] .'</span> <br>
				<label>Фамилия:</label> <span>'. $_SESSION["last_name"] .'</span> <br>
			</div>
		';
	}
}

?>