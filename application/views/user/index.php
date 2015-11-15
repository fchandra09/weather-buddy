<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); }

if (strcasecmp("Schedule", $user->Home_Screen) == 0) {
	$homeScreen = "Schedule Based Weather";
}
else {
	$homeScreen = "Today's Weather";
}
?>

<div class="container main-container">
	<h2 class="page-header">User Info</h2>

	<div class="section form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label">First Name</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?php echo $user->First_Name ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Last Name</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?php echo $user->Last_Name ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Email</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?php echo $user->Email ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Temperature Unit</label>
			<div class="col-sm-10">
				<p class="form-control-static">&deg;<?php echo $user->Temperature_Unit ?></p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Time Format</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?php echo $user->Time_Format ?>-Hour</p>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label">Home Screen</label>
			<div class="col-sm-10">
				<p class="form-control-static"><?php echo $homeScreen ?></p>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="button" id="edit" class="btn btn-default">Edit</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('#edit').click(function(){
			window.location.href = '<?php echo URL_WITH_INDEX_FILE; ?>user/edit';
		});
	});
</script>