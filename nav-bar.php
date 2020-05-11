<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-education" style="font-size: 20pt"></span></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li <?php check_active("index") ?> ><a href="index.php">Начало</a></li>
		
		<?php if (isset($_SESSION["role"]) && $_SESSION["role"] != "administrator") { ?>
			<li <?php check_active("current_grades") ?> ><a href="current_grades.php">Текущи оценки</a></li>
			<li <?php check_active("term_grades") ?> ><a href="term_grades.php">Срочни оценки</a></li>
			<li <?php check_active("session_grades") ?> ><a href="session_grades.php">Годишни оценки</a></li>
		<?php } ?>
		
		<?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "class teacher") { ?>
			<li <?php check_active("students") ?> ><a href="students.php">Управление на собствения клас</a></li>
		<?php } ?>
		
		<?php if (isset($_SESSION["role"]) && $_SESSION["role"] === "administrator") { ?>
			<li <?php check_active("teachers") ?> ><a href="teachers.php">Учители</a></li>
			<li <?php check_active("subjects") ?> ><a href="subjects.php">Предмети</a></li>
			<li <?php check_active("teacher_subjects") ?> ><a href="teacher_subjects.php">Кой учител по какво преподава</a></li>
			<li <?php check_active("classes") ?> ><a href="classes.php">Класове</a></li>
			<li <?php check_active("class_teachers") ?> ><a href="class_teachers.php">На кой клас кои учители преподават</a></li>
			<li <?php check_active("students") ?> ><a href="students.php">Ученици</a></li>
			<li <?php check_active("school_control") ?> ><a href="school_control.php">Управление на училището</a></li>
			<li <?php check_active("current_grades") || check_active("term_grades") || check_active("session_grades") ?> class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Оценки<span class="caret"></span></a>
				<ul class="dropdown-menu">
				  <li><a href="current_grades.php">Текущи оценки</a></li>
				  <li><a href="term_grades.php">Срочни оценки</a></li>
				  <li><a href="session_grades.php">Годишни оценки</a></li>
				</ul>
			</li>		
		<?php } ?>
		
      </ul>
      <ul class="nav navbar-nav navbar-right">
	    <?php if(isset($_SESSION["username"])) { ?>
			<?php if ($_SESSION["role"] != "administrator") { ?>
				<li <?php check_active("profile") ?> ><a href="profile.php"><?php echo $_SESSION["first_name"]." ".$_SESSION["last_name"] ?></a></li>
			<?php } else { ?>
				<li <?php check_active("profile") ?> ><a href="profile.php"><?php echo "Administrator" ?></a></li>
			<?php } ?>
			<li><a href="profile.php?logout=1"><span class="glyphicon glyphicon-log-out"></span> Изход</a></li>
		<?php } ?>
      </ul>
    </div>
  </div>
</nav>

<?php
function check_active($page) {
	if (isset($GLOBALS["page_now"]))
		if ($page == $GLOBALS["page_now"]) {
		echo "class='active'";
	} else {
		echo "";
	}
}
?>