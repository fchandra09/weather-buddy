<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); }

if (is_numeric($scheduleID))
{
	$title = "Edit Schedule";
}
else
{
	$title = "New Schedule";
}

if (strcasecmp($GLOBALS["beans"]->siteHelper->getSession("timeFormat"), "24") == 0) {
	$startTime = $schedule->Start_Time_24;
	$endTime = $schedule->End_Time_24;
	$showMeridian = "false";
}
else {
	$startTime = $schedule->Start_Time_12;
	$endTime = $schedule->End_Time_12;
	$showMeridian = "true";
}
?>

		<tr class="table-panel-content">
			<td colspan="4">
				<h2 class="page-header"><?php echo $title; ?></h2>
				<form id="form" method="post" action="<?php echo URL_WITH_INDEX_FILE; ?>schedule/save" class="form-horizontal">
					<input type="hidden" id="scheduleID" name="scheduleID" value="<?php echo $scheduleID ?>" />
					<input type="hidden" id="userID" name="userID" value="<?php echo $userID ?>" />

					<div class="form-group required">
						<label for="days" class="col-sm-2 control-label">Days</label>
						<div class="col-sm-10 form-field">
							<?php foreach (explode(",", "Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday") as $day) { ?>
								<div class="checkbox">
									<label>
										<input type="checkbox" id="<?php echo strtolower($day); ?>" name="<?php echo strtolower($day); ?>" class="days" <?php if ($schedule->{$day} == 1) { ?>checked<?php } ?> />
										<?php echo $day; ?>
									</label>
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label for="startTime" class="col-sm-2 control-label">Start Time</label>
						<div class="col-sm-10 form-field short">
							<div class="input-group bootstrap-timepicker timepicker col-sm-2">
								<input type="text" id="startTime" name="startTime" value="<?php echo $startTime ?>" class="form-control" required aria-required="true" />
								<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="endTime" class="col-sm-2 control-label">End Time</label>
						<div class="col-sm-10 form-field short">
							<div class="input-group bootstrap-timepicker timepicker col-sm-2">
								<input type="text" id="endTime" name="endTime" value="<?php echo $endTime ?>" class="form-control" required aria-required="true" />
								<span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10 form-button">
							<button type="button" id="cancel" class="btn btn-default">Cancel</button>
							<button type="submit" class="btn btn-default">Save</button>
						</div>
					</div>
				</form>
			</td>
		</tr>
	</table>
</div>

<script>
	$(document).ready(function(){
		$('#cancel').click(function(){
			window.location.href = '<?php echo URL_WITH_INDEX_FILE; ?>schedule';
		});

		$('.input-group.timepicker').find('input[type="text"]').each(function() {
			$(this).timepicker({
				defaultTime: false,
				showMeridian: <?php echo $showMeridian; ?>
			});
		});

		$('#form').validate({
			groups: {
				days: 'monday tuesday wednesday thursday friday saturday sunday'
			},
			rules: {
				monday: {
					require_from_group: [1, '.days']
				},
				tuesday: {
					require_from_group: [1, '.days']
				},
				wednesday: {
					require_from_group: [1, '.days']
				},
				thursday: {
					require_from_group: [1, '.days']
				},
				friday: {
					require_from_group: [1, '.days']
				},
				saturday: {
					require_from_group: [1, '.days']
				},
				sunday: {
					require_from_group: [1, '.days']
				}
			}
		});
	});
</script>