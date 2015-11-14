<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); }

$firstName = $user->First_Name;
$lastName = $user->Last_Name;
$email = $user->Email;
?>

<script>
	$(document).ready(function(){
		$('#cancel').click(function(){
			window.location.href = '<?php echo URL_WITH_INDEX_FILE; ?>user';
		});

		$('#form').validate({});
	});
</script>

<div class="container">
	<h2 class="page-header">Edit User Info</h2>
	<form id="form" method="post" action="<?php echo URL_WITH_INDEX_FILE; ?>user/save" class="form-horizontal">
		<input type="hidden" id="userID" name="userID" value="<?php echo $userID ?>" />

		<?php require '_editLogin.php' ?>

		<div class="form-group">
			<label for="temperatureUnit" class="col-sm-2 control-label">Temperature Unit</label>
			<div class="col-sm-10">
				<div class="radio-inline">
					<label>
						<input type="radio" id="temperatureUnitF" name="temperatureUnit" value="F" <?php if ($user->Temperature_Unit == "F") { ?>checked<?php } ?> />
						&deg;F
					</label>
				</div>
				<div class="radio-inline">
					<label>
						<input type="radio" id="temperatureUnitC" name="temperatureUnit" value="C" <?php if ($user->Temperature_Unit == "C") { ?>checked<?php } ?> />
						&deg;C
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="timeFormat" class="col-sm-2 control-label">Time Format</label>
			<div class="col-sm-10">
				<div class="radio-inline">
					<label>
						<input type="radio" id="timeFormat12" name="timeFormat" value="12" <?php if ($user->Time_Format == "12") { ?>checked<?php } ?> />
						12-Hour
					</label>
				</div>
				<div class="radio-inline">
					<label>
						<input type="radio" id="timeFormat24" name="timeFormat" value="24" <?php if ($user->Time_Format == "24") { ?>checked<?php } ?> />
						24-Hour
					</label>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="homeScreen" class="col-sm-2 control-label">Home Screen</label>
			<div class="col-sm-10">
				<div class="radio-inline">
					<label>
						<input type="radio" id="homeScreenToday" name="homeScreen" value="Today" <?php if (strcasecmp("Today", $user->Home_Screen) == 0) { ?>checked<?php } ?> />
						Today's Weather
					</label>
				</div>
				<div class="radio-inline">
					<label>
						<input type="radio" id="homeScreenSchedule" name="homeScreen" value="Schedule" <?php if (strcasecmp("Schedule", $user->Home_Screen) == 0) { ?>checked<?php } ?> />
						Schedule Based Weather
					</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="button" id="cancel" class="btn btn-default">Cancel</button>
				<button type="submit" class="btn btn-default">Save</button>
			</div>
		</div>
	</form>
</div>