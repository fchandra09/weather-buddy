<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
	<div class="clearfix">
		<div class="location">
			<span id="location-text">Champaign, IL 61820</span><br/>
			<span id="date-text"><?php echo date('F d, Y', time()); ?></span>
		</div>
		<div class="share">
			Share
		</div>
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

	<div class="important-info text-center today">
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

	<ul class="nav nav-tabs weather-tabs">
		<li id="hourly-tab" class="active">
			<a href="#">Hourly</a>
		</li>
		<li id="future-tab">
			<a href="#">5-Day</a>
		</li>
	</ul>
	<div class="panel panel-default weather-details today">
		<div class="panel-body">
			<div class="table-responsive">
				<table id="hourly-table" class="table today-details">
					<tbody>
						<tr class="text-center">
							<td id="time-1" colspan="2" class="no-border">9:00 AM</td>
							<td id="time-2" colspan="2">10:00 AM</td>
							<td id="time-3" colspan="2">11:00 AM</td>
							<td id="time-4" colspan="2">12:00 PM</td>
							<td id="time-5" colspan="2">1:00 PM</td>
						</tr>
						<tr class="text-center temperature-row">
							<td id="temperature-1" colspan="2" class="no-border">83&deg;F</td>
							<td id="temperature-2" colspan="2">86&deg;F</td>
							<td id="temperature-3" colspan="2">83&deg;F</td>
							<td id="temperature-4" colspan="2">75&deg;F</td>
							<td id="temperature-5" colspan="2">70&deg;F</td>
						</tr>
						<tr class="text-center">
							<td id="hourly-icon-1" colspan="2" class="no-border"><div class="weather-icon sun" /></td>
							<td id="hourly-icon-2" colspan="2"><div class="weather-icon sun" /></td>
							<td id="hourly-icon-3" colspan="2"><div class="weather-icon sun" /></td>
							<td id="hourly-icon-4" colspan="2"><div class="weather-icon cloud" /></td>
							<td id="hourly-icon-5" colspan="2"><div class="weather-icon cloud" /></td>
						</tr>
						<tr>
							<td class="text-right no-border">Feels Like:</td>
							<td class="no-border" id="feels-like-1">82&deg;F</td>
							<td class="text-right">Feels Like:</td>
							<td class="no-border" id="feels-like-2">83&deg;F</td>
							<td class="text-right">Feels Like:</td>
							<td class="no-border" id="feels-like-3">83&deg;F</td>
							<td class="text-right">Feels Like:</td>
							<td class="no-border" id="feels-like-4">72&deg;F</td>
							<td class="text-right">Feels Like:</td>
							<td class="no-border" id="feels-like-5">69&deg;F</td>
						</tr>
						<tr>
							<td class="text-right no-border">Precipitation:</td>
							<td class="no-border" id="precipitation-1">68%</td>
							<td class="text-right">Precipitation:</td>
							<td class="no-border" id="precipitation-2">70%</td>
							<td class="text-right">Precipitation:</td>
							<td class="no-border" id="precipitation-3">70%</td>
							<td class="text-right">Precipitation:</td>
							<td class="no-border" id="precipitation-4">80%</td>
							<td class="text-right">Precipitation:</td>
							<td class="no-border" id="precipitation-5">95%</td>
						</tr>
						<tr>
							<td class="text-right no-border">Humidity:</td>
							<td class="no-border" id="humidity-1">23%</td>
							<td class="text-right">Humidity:</td>
							<td class="no-border" id="humidity-2">30%</td>
							<td class="text-right">Humidity:</td>
							<td class="no-border" id="humidity-3">40%</td>
							<td class="text-right">Humidity:</td>
							<td class="no-border" id="humidity-4">54%</td>
							<td class="text-right">Humidity:</td>
							<td class="no-border" id="humidity-5">72%</td>
						</tr>
						<tr>
							<td class="text-right no-border">Wind Speed:</td>
							<td class="no-border" id="wind-speed-1">5 mph W</td>
							<td class="text-right">Wind Speed:</td>
							<td class="no-border" id="wind-speed-2">6 mph W</td>
							<td class="text-right">Wind Speed:</td>
							<td class="no-border" id="wind-speed-3">8 mph W</td>
							<td class="text-right">Wind Speed:</td>
							<td class="no-border" id="wind-speed-4">8 mph W</td>
							<td class="text-right">Wind Speed:</td>
							<td class="no-border" id="wind-speed-5">12 mph W</td>
						</tr>
					</tbody>
				</table>
				<table id="future-table" class="table today-details">
					<tbody>
						<tr class="text-center">
							<td id="day-1" class="no-border">Monday</td>
							<td id="day-2">Tuesday</td>
							<td id="day-3">Wednesday</td>
							<td id="day-4">Thursday</td>
							<td id="day-5">Friday</td>
						</tr>
						<tr class="text-center temperature-row">
							<td id="high-low-1" class="no-border">83&deg;F / 59&deg;F</td>
							<td id="high-low-2">70&deg;F / 55&deg;F</td>
							<td id="high-low-3">68&deg;F / 50&deg;F</td>
							<td id="high-low-4">65&deg;F / 52&deg;F</td>
							<td id="high-low-5">60&deg;F / 40&deg;F</td>
						</tr>
						<tr class="text-center">
							<td id="future-icon-1" class="no-border"><div class="weather-icon sun" /></td>
							<td id="future-icon-2"><div class="weather-icon cloud" /></td>
							<td id="future-icon-3"><div class="weather-icon cloud" /></td>
							<td id="future-icon-4"><div class="weather-icon rain" /></td>
							<td id="future-icon-5"><div class="weather-icon cloud" /></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('#future-table').hide();

		$('#hourly-tab,#future-tab').click(toggleTab);
	});

	toggleTab = function() {
		if ($(this).attr('id') == 'future-tab') {
			$('#hourly-tab').removeClass('active');
			$('#future-tab').addClass('active');
			$('#hourly-table').hide();
			$('#future-table').show();
		}
		else {
			$('#future-tab').removeClass('active');
			$('#hourly-tab').addClass('active');
			$('#future-table').hide();
			$('#hourly-table').show();
		}
	}
</script>