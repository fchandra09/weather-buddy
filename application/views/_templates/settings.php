<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
	<ul class="nav nav-tabs">
		<li role="presentation" <?php if (strcasecmp("user", $activeView) == 0) { ?>class="active"<?php } ?>>
			<a href="<?php echo URL_WITH_INDEX_FILE; ?>user">User Info</a>
		</li>
		<li role="presentation" <?php if (strcasecmp("feels", $activeView) == 0) { ?>class="active"<?php } ?>>
			<a href="<?php echo URL_WITH_INDEX_FILE; ?>feels">Feels</a>
		</li>
		<li role="presentation" <?php if (strcasecmp("schedule", $activeView) == 0) { ?>class="active"<?php } ?>>
			<a href="<?php echo URL_WITH_INDEX_FILE; ?>schedule">Schedule</a>
		</li>
	</ul>
</div>