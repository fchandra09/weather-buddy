<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
	<div class="location">
		Champaign, IL 61820<br/>
		November 17, 2015
	</div>

	<?php if (is_numeric($userID)) { ?>
		<div class="main-link">
			<a href="<?php echo URL_WITH_INDEX_FILE; ?>home/scheduled">
				See Personalized Weather
				<span class="glyphicon glyphicon-chevron-right"></span>
			</a>
		</div>

		<div class="welcome text-center">Welcome, <?php echo $user->First_Name ?>!</div>
	<?php } ?>

	<div class="important-info text-center">
		83&deg;F
	</div>
	<div class="additional-info text-center">
		<?php if (is_numeric($userID)) { ?>
			Scorching hot
			<span class="glyphicon glyphicon-pencil"></span><br/>
			Bring / Wear: Sleeveless<br/>
		<?php } ?>
		Sunrise 5:45 AM, Sunset 6:07 PM
	</div>

	<div class="panel panel-default weather-details">
		<div class="panel-body">
		</div>
	</div>
</div>