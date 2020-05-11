<?php 
if (!isset($input_errors)) $input_errors=array();
if (!isset($input_success)) $input_success=array();
?>

<!-- Show Error Messages -->
<?php if(count($input_errors) > 0) { ?>
	<div class="input_messages alert alert-danger" role="alert">
		<?php foreach($input_errors as $error) { ?>
			<p><?php echo $error; ?></p>
		<?php } ?>
	</div>
<?php } ?>

<!-- Show Success Messages -->
<?php if(count($input_success) > 0) { ?>
	<div class="input_messages alert alert-success" role="alert">
		<?php foreach($input_success as $success) { ?>
			<p><?php echo $success; ?></p>
		<?php } ?>
	</div>
<?php } ?>


<?php 

if(isset($_GET["error"])) {
	switch($_GET["error"]) {
		case 1 : echo '<p class="input_messages alert alert-danger" role="alert">Моля попълнете всички полета!</p>'; break;
		case 2 : echo '<p class="input_messages alert alert-danger" role="alert">ЕГН трябва да бъде 10 символа!</p>'; break;
		case 3 : echo '<p class="input_messages alert alert-danger" role="alert">Редактирането не беше успешно!</p>'; break;
		case 4 : echo '<p class="input_messages alert alert-danger" role="alert">Изтриването не беше успешно!</p>'; break;
	}
}

if(isset($_GET["success"])) {
	switch($_GET["success"]) {
		case 1 : echo '<p class="input_messages alert alert-success" role="alert">Записът беше успешно вмъкнат в базата данни!</p>'; break;
		case 3 : echo '<p class="input_messages alert alert-warning" role="alert">Редактирането беше успешно!</p>'; break;
		case 4 : echo '<p class="input_messages alert alert-success" role="alert">Изтриването беше успешно!</p>'; break;
	}
}

?>