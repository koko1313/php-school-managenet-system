<div class="row">
<form class="form-inline">

	<?php if( ($_SESSION["role"] != "student" && $page_now!="students") || ($page_now=="students" && $_SESSION["role"] === "administrator") ) { ?>
		<div class="form-group filters">
			<div class="input-group mb-2 mb-sm-0">
				<div class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></div>
				<select id="gradesFilterByClass_now" onChange="gradesFilterBy('Class_now')" class="form-control">
					<option value="">Покажи всички класове</option>
					<?php echo createOptions("students_filter_by_class"); ?>
				</select>
			</div>
		</div>
	<?php } ?>


	<?php if($page_now != "session_grades" && $page_now != "students" ) { ?>
	<div class="form-group filters">
		<div class="input-group mb-2 mb-sm-0">
			<div class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></div>
			<select id="gradesFilterByTerm" onChange="gradesFilterBy('Term')" class="form-control">
				<option value="">Покажи всички срокове</option>
				<?php echo createOptions("terms"); ?>
			</select>
		</div>
	</div>
	<?php } ?>

	<?php if($page_now != "students") { ?>
	<div class="form-group filters">
		<div class="input-group mb-2 mb-sm-0">
			<div class="input-group-addon"><span class="glyphicon glyphicon-filter"></span></div>
			<select id="gradesFilterByFor_class" onChange="gradesFilterBy('For_class')" class="form-control">
				<option value="">Покажи за всички класове</option>
				<?php echo createOptions("classes_as_text"); ?>
			</select>
		</div>
	</div>
	<?php } ?>
	
</form>
</div>