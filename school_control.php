<?php 
include("user_session_control.php");
if (empty($_SESSION["username"]) || $_SESSION["role"] != "administrator") header("location: index.php");
include("school_session_control_functions.php");
include("create_options.php");
$page_now="school_control";
?>


<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link type="text/css" rel="stylesheet" href="styles/style.css">
</head>
<body>

<?php include("nav-bar.php"); ?>


<div class="container-fluid">

<h2>Управление на учебната година</h2>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<form method="post" name="form" action="school_control.php">
			<?php include("errors_success_messages.php"); ?>
			<div class="form-group">
				<label>Текущ учебен срок</label>
				<select name="term" class="form-control">
				  <?php echo createOptions("terms"); ?>
				</select>
			</div>
			<button class="btn btn-primary" name="change_school_session" type="submit">Смени срока</button>
		</form>
		<br>
		<button class="btn btn-primary" data-toggle="modal" data-target="#confirmModal">Премини на следваща учебна година</button>
	</div>
</div>

<h2>Управление на училището</h2>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<form method="post" name="form" action="school_control.php" enctype="multipart/form-data">
			<div class="form-group">
				<label>Име на училището</label>
				<input type="text" name="school_name" class="form-control" value="<?php echo $school_name; ?>">
			</div>
			<div class="form-group">
				<label>Снимка <span class="glyphicon glyphicon-picture"></span></label>
				<input type="file" class="form-control-file" name="image">
				<small class="form-text text-muted">Снимката трябва да е в JPG формат.</small>
			</div>
			<div class="form-group">
				<label>Описание на училището</label>
				<textarea name="school_description" class="form-control" rows="10"><?php echo $school_description ?></textarea>
			</div>
			<button class="btn btn-primary" name="change_school_details" type="submit">Промени</button>
		</form>
	</div>
</div>

</div>

<?php include("footer.php"); ?>	

<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Премини на следваща учебна година</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Всички класове ще се инкрементират с 1 и всички 12-ти класове ще бъдат изтрити, заедно с всички ученици и техните оценки.</p>
		<p>Ще преминете към Първи срок на следващата учебна година.</p>
      </div>
      <div class="modal-footer">
		<form method="post" name="form" action="school_control.php">
			<button class="btn btn-warning" name="increment_school_session" type="submit">Продължи</button>
		</form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="scripts/bootstrap.min.js"></script>
<script>
// за да показва новите редове в textarea
var editor = CodeMirror.fromTextArea(document.getElementById("description"), {
    lineNumbers: true,
    matchBrackets: true
});
</script>
</body>
</html>