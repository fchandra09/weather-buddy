<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container settings-container">
	<table class="table-panel">
		<tr class="table-panel-tabs">
			<td class="table-panel-tab<?php if (strcasecmp("user", $activeView) == 0) { ?> active<?php } ?>">
				<a href="<?php echo URL_WITH_INDEX_FILE; ?>user">User Info</a>
			</td>
			<td class="table-panel-tab<?php if (strcasecmp("feels", $activeView) == 0) { ?> active<?php } ?>">
				<a href="<?php echo URL_WITH_INDEX_FILE; ?>feels">Feels</a>
			</td>
			<td class="table-panel-tab<?php if (strcasecmp("schedule", $activeView) == 0) { ?> active<?php } ?>">
				<a href="<?php echo URL_WITH_INDEX_FILE; ?>schedule">Schedule</a>
			</td>
			<td></td>
		</tr>
