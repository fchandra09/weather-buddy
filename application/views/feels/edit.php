<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); }

if (is_numeric($feelID))
{
	$title = "Edit Feel";
}
else
{
	$title = "New Feel";
}

if (strcasecmp($GLOBALS["beans"]->siteHelper->getSession("temperatureUnit"), "C") == 0) {
	$minTemperature = $feel->Min_Temperature_C;
	$maxTemperature = $feel->Max_Temperature_C;
	$unit = "&deg;C";
}
else {
	$minTemperature = $feel->Min_Temperature_F;
	$maxTemperature = $feel->Max_Temperature_F;
	$unit = "&deg;F";
}
?>

<div class="container">
	<h2 class="page-header"><?php echo $title; ?></h2>
	<form id="form" method="post" action="<?php echo URL_WITH_INDEX_FILE; ?>feels/save" class="form-horizontal">
		<input type="hidden" id="feelID" name="feelID" value="<?php echo $feelID ?>" />
		<input type="hidden" id="userID" name="userID" value="<?php echo $userID ?>" />

		<div class="form-group">
			<label for="minTemperature" class="col-sm-2 control-label">Min Temperature</label>
			<div class="col-sm-10">
				<div class="input-group col-sm-2">
					<input type="text" id="minTemperature" name="minTemperature" value="<?php echo $minTemperature ?>" class="form-control" required aria-required="true" />
					<span class="input-group-addon"><?php echo $unit; ?></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="maxTemperature" class="col-sm-2 control-label">Max Temperature</label>
			<div class="col-sm-10">
				<div class="input-group col-sm-2">
					<input type="text" id="maxTemperature" name="maxTemperature" value="<?php echo $maxTemperature ?>" class="form-control" required aria-required="true" />
					<span class="input-group-addon"><?php echo $unit; ?></span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label for="description" class="col-sm-2 control-label">Feel</label>
			<div class="col-sm-10">
				<input type="text" id="description" name="description" value="<?php echo $feel->Description ?>" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label for="bringWear" class="col-sm-2 control-label">Bring/Wear</label>
			<div class="col-sm-10">
				<textarea id="bringWear" name="bringWear" class="form-control"><?php echo $feel->Bring_Wear ?></textarea>
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

<script>
	$(document).ready(function(){
		$('#cancel').click(function(){
			window.location.href = '<?php echo URL_WITH_INDEX_FILE; ?>feels';
		});

		$('#form').validate({
			rules: {
				minTemperature: {
					integer: true
				},
				maxTemperature: {
					integer: true
				}
			}
		});
	});
</script>