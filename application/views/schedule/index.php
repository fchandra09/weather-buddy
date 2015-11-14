<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
	<h2 class="page-header">Schedule</h2>

	<p>
		List the times you would like to keep track of the weather.
	</p>

	<div class="clearfix table-action">
		<button type="button" id="add" class="btn btn-default pull-left">Add</button>
	</div>

	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="1%">&nbsp;</th>
					<th width="1%">&nbsp;</th>
					<th>Days</th>
					<th>Start Time</th>
					<th>End Time</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($scheduleList as $schedule) { ?>
					<tr>
						<td width="1%">
							<button type="button" class="btn btn-default btn-xs" aria-label="Edit" onclick="editSchedule(<?php echo $schedule->ID ?>);">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
							</button>
						</td>
						<td width="1%">
							<button type="button" class="btn btn-default btn-xs" aria-label="Delete" onclick="deleteSchedule(<?php echo $schedule->ID ?>);">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
						</td>
						<td>
							<?php $i = 0;
							foreach (explode(",", "Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday") as $day) {
								if ($i > 0) {
									echo " ";
								}
								if ($schedule->{$day} == 1) {
									echo $GLOBALS["beans"]->stringHelper->left($day, 3);
									$i += 1;
								}
							} ?>
						</td>
						<?php if (strcasecmp($GLOBALS["beans"]->siteHelper->getSession("timeFormat"), "24") == 0) { ?>
							<td><?php echo $schedule->Start_Time_24 ?></td>
							<td><?php echo $schedule->End_Time_24 ?></td>
						<?php } else { ?>
							<td><?php echo $schedule->Start_Time_12 ?></td>
							<td><?php echo $schedule->End_Time_12 ?></td>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	$(document).ready(function(){
		$('#add').click(function(){
			window.location.href = '<?php echo URL_WITH_INDEX_FILE; ?>schedule/edit';
		});
	});

	editSchedule = function(scheduleID) {
		window.location.href = '<?php echo URL_WITH_INDEX_FILE; ?>schedule/edit/' + scheduleID;
	}

	deleteSchedule = function(scheduleID) {
		if (confirm('Are you sure you want to delete this record?')) {
			window.location.href = '<?php echo URL_WITH_INDEX_FILE; ?>schedule/delete/' + scheduleID;
		}
	}
</script>