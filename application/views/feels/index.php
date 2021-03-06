<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

		<tr class="table-panel-content">
			<td colspan="4">
				<h2 class="page-header">Feels</h2>

				<p>
					Personalize how a temperature range feels to you and what items to bring/wear.
					Umbrella will be automatically suggested when it rains.
				</p>

				<div class="clearfix table-action">
					<button type="button" id="add" class="btn btn-default pull-left">Add</button>
				</div>

				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th width="1%">&nbsp;</th>
								<th>Min Temperature</th>
								<th>Max Temperature</th>
								<th>Feel</th>
								<th>Bring / Wear</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($feels as $feel) { ?>
								<tr>
									<td width="1%" class="column-action">
										<span title="Edit" onclick="editFeel(<?php echo $feel->ID ?>);">
											<i class="glyphicon glyphicon-pencil"></i>
										</span>
										<span title="Delete" onclick="deleteFeel(<?php echo $feel->ID ?>);">
											<i class="glyphicon glyphicon-remove"></i>
										</span>
									</td>
									<?php if (strcasecmp($GLOBALS["beans"]->siteHelper->getSession("temperatureUnit"), "C") == 0) { ?>
										<td><?php echo $feel->Min_Temperature_C ?>&deg;C</td>
										<td><?php echo $feel->Max_Temperature_C ?>&deg;C</td>
									<?php } else { ?>
										<td><?php echo $feel->Min_Temperature_F ?>&deg;F</td>
										<td><?php echo $feel->Max_Temperature_F ?>&deg;F</td>
									<?php } ?>
									<td><?php echo $feel->Description ?></td>
									<td><?php echo $feel->Bring_Wear ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</td>
		</tr>
	</table>
</div>

<script>
	$(document).ready(function(){
		$('#add').click(function(){
			window.location.href = '<?php echo URL_WITH_INDEX_FILE; ?>feels/edit';
		});
	});

	editFeel = function(feelID) {
		window.location.href = '<?php echo URL_WITH_INDEX_FILE; ?>feels/edit/' + feelID;
	}

	deleteFeel = function(feelID) {
		if (confirm('Are you sure you want to delete this record?')) {
			window.location.href = '<?php echo URL_WITH_INDEX_FILE; ?>feels/delete/' + feelID;
		}
	}
</script>