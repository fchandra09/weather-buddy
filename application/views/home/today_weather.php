<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
	<div class="clearfix">
		<div class="location">
			<span id="location-text"></span><br/>
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

	<div id="current-temperature-text" class="important-info text-center today"></div>
	<div class="additional-info text-center">
		<?php if (is_numeric($userID)) { ?>
			<span id="feel-text"></span>
			<a id="edit-feel" href="#" title="Edit" class="edit-link">
				<span class="glyphicon glyphicon-pencil"></span>
			</a>
			<span id="bring-text"></span>
		<?php } ?>
		Sunrise: <span id="sunrise-text"></span>, Sunset: <span id="sunset-text"></span>
	</div>

	<table class="table-panel weather-details">
		<tr class="table-panel-tabs">
			<td class="table-panel-tab active">
				<span id="hourly-tab">Hourly</span>
			</td>
			<td class="table-panel-tab">
				<span id="future-tab">5-Day</span>
			</td>
			<td></td>
		</tr>
		<tr class="table-panel-content">
			<td colspan="3">
				<div class="table-responsive">
					<table id="hourly-table" class="table today-details">
						<tbody>
							<tr class="text-center">
								<td id="time-1" colspan="2" class="no-border" />
								<td id="time-2" colspan="2" />
								<td id="time-3" colspan="2" />
								<td id="time-4" colspan="2" />
								<td id="time-5" colspan="2" />
							</tr>
							<tr class="text-center temperature-row">
								<td id="temperature-1" colspan="2" class="no-border" />
								<td id="temperature-2" colspan="2" />
								<td id="temperature-3" colspan="2" />
								<td id="temperature-4" colspan="2" />
								<td id="temperature-5" colspan="2" />
							</tr>
							<tr class="text-center">
								<td id="hourly-icon-1" colspan="2" class="no-border"><div class="weather-icon"></div></td>
								<td id="hourly-icon-2" colspan="2"><div class="weather-icon"></div></td>
								<td id="hourly-icon-3" colspan="2"><div class="weather-icon"></div></td>
								<td id="hourly-icon-4" colspan="2"><div class="weather-icon"></div></td>
								<td id="hourly-icon-5" colspan="2"><div class="weather-icon"></div></td>
							</tr>
							<tr>
								<td class="text-right no-border">Feels Like:</td>
								<td class="no-border" id="feels-like-1" />
								<td class="text-right">Feels Like:</td>
								<td class="no-border" id="feels-like-2" />
								<td class="text-right">Feels Like:</td>
								<td class="no-border" id="feels-like-3" />
								<td class="text-right">Feels Like:</td>
								<td class="no-border" id="feels-like-4" />
								<td class="text-right">Feels Like:</td>
								<td class="no-border" id="feels-like-5" />
							</tr>
							<tr>
								<td class="text-right no-border">Precipitation:</td>
								<td class="no-border" id="precipitation-1" />
								<td class="text-right">Precipitation:</td>
								<td class="no-border" id="precipitation-2" />
								<td class="text-right">Precipitation:</td>
								<td class="no-border" id="precipitation-3" />
								<td class="text-right">Precipitation:</td>
								<td class="no-border" id="precipitation-4" />
								<td class="text-right">Precipitation:</td>
								<td class="no-border" id="precipitation-5" />
							</tr>
							<tr>
								<td class="text-right no-border">Humidity:</td>
								<td class="no-border" id="humidity-1" />
								<td class="text-right">Humidity:</td>
								<td class="no-border" id="humidity-2" />
								<td class="text-right">Humidity:</td>
								<td class="no-border" id="humidity-3" />
								<td class="text-right">Humidity:</td>
								<td class="no-border" id="humidity-4" />
								<td class="text-right">Humidity:</td>
								<td class="no-border" id="humidity-5" />
							</tr>
							<tr>
								<td class="text-right no-border">Wind Speed:</td>
								<td class="no-border" id="wind-speed-1" />
								<td class="text-right">Wind Speed:</td>
								<td class="no-border" id="wind-speed-2" />
								<td class="text-right">Wind Speed:</td>
								<td class="no-border" id="wind-speed-3" />
								<td class="text-right">Wind Speed:</td>
								<td class="no-border" id="wind-speed-4" />
								<td class="text-right">Wind Speed:</td>
								<td class="no-border" id="wind-speed-5" />
							</tr>
						</tbody>
					</table>
					<table id="future-table" class="table today-details">
						<tbody>
							<tr class="text-center">
								<td id="day-1" class="no-border" />
								<td id="day-2" />
								<td id="day-3" />
								<td id="day-4" />
								<td id="day-5" />
							</tr>
							<tr class="text-center temperature-row">
								<td id="high-low-1" class="no-border" />
								<td id="high-low-2" />
								<td id="high-low-3" />
								<td id="high-low-4" />
								<td id="high-low-5" />
							</tr>
							<tr class="text-center">
								<td id="future-icon-1" class="no-border"><div class="weather-icon" /></td>
								<td id="future-icon-2"><div class="weather-icon"></div></td>
								<td id="future-icon-3"><div class="weather-icon"></div></td>
								<td id="future-icon-4"><div class="weather-icon"></div></td>
								<td id="future-icon-5"><div class="weather-icon"></div></td>
							</tr>
						</tbody>
					</table>
				</div>
			</td>
		</tr>
	</table>
</div>

<script>
	$(document).ready(function() {
		$('#future-table').hide();

		$('#hourly-tab,#future-tab').click(toggleTab);

		<?php if (!is_object($GLOBALS["beans"]->siteHelper->getSession("location"))) { ?>
			/* Get default location based on IP */
			$.ajax({
				url: 'http://api.ipinfodb.com/v3/ip-city/',
				async: false,
				cache: false,
				dataType: 'json',
				data: {
					key: '310509df93ae5e7fac78da40746729588ecf4ea3b2ff3bb2d999c7b3d858ccb1',
					format: 'json'
				},
				success: function(result) {
					saveDefaultLocationToSession(result);
				}
			});
		<?php } ?>

		<?php if (strcasecmp($GLOBALS["beans"]->siteHelper->getSession("temperatureUnit"), "C") == 0) { ?>
			var apiUnit = 'metric';
			var unit = 'C';
		<?php } else { ?>
			var apiUnit = 'imperial';
			var unit = 'F';
		<?php } ?>

		/* Get default location */
		$.ajax({
			url: '<?php echo URL_WITH_INDEX_FILE; ?>home/getDefaultLocation',
			async: false,
			cache: false,
			method: 'POST',
			dataType: 'json',
			success: function(result) {
				var locationText = result.city + ', ';
				if (result.country.toLowerCase() == 'united states') {
					locationText = locationText + result.region;
				}
				else {
					locationText = locationText + result.country;
				}
				$('#location-text').html(locationText);

				//populate3HourData(result, apiUnit, unit);
				populate5DayData(result, apiUnit, unit);
				populateHourlyData(result, unit);
			}
		});
	});

	toggleTab = function() {
		if ($(this).attr('id') == 'future-tab') {
			$('#hourly-tab').closest('td').removeClass('active');
			$('#future-tab').closest('td').addClass('active');
			$('#hourly-table').hide();
			$('#future-table').show();
		}
		else {
			$('#future-tab').closest('td').removeClass('active');
			$('#hourly-tab').closest('td').addClass('active');
			$('#future-table').hide();
			$('#hourly-table').show();
		}
	}

	saveDefaultLocationToSession = function(result) {
		var url = '<?php echo URL_WITH_INDEX_FILE; ?>home/setDefaultLocation';
		url = url + '/' + result.cityName;
		url = url + '/' + result.regionName;
		url = url + '/' + result.countryName;
		url = url + '/' + result.zipCode;
		url = url + '/' + result.latitude;
		url = url + '/' + result.longitude;
		url = url + '/' + result.timeZone;

		$.ajax({
			url: url,
			async: false,
			cache: false,
			method: 'POST'
		});
	}
	populateHourlyData = function(result, unit){
		$.getJSON("https://api.forecast.io/forecast/0e5e272af26d7da6b94ffd58bf3b7f7a/"+result.latitude+","+result.longitude+"?callback=?", function(data){
			console.log("FORECAST DATA");
			console.log(data);
			if(data){
				//fill sunrise and sunset times:
				var sunriseTime = convertUnixToHumanTime(data.daily.data[0].sunriseTime); 
				var sunsetTime = convertUnixToHumanTime(data.daily.data[0].sunsetTime);  
				console.log(sunriseTime + " " + sunsetTime);
				$('#sunrise-text').html(sunriseTime);
				$('#sunset-text').html(sunsetTime);

				//Current temperature
				var currTemperature = checkTemperatureUnit(data.hourly.data[0].temperature, unit);
				$('#current-temperature-text').html(currTemperature + '&deg;' + unit);
				<?php if (is_numeric($userID)) { ?>
					populateFeelData(currTemperature);
				<?php } ?>

				//fill hourly data for next 5 hours
				for (var i = 0; i < 5; i++){
					var temperature = checkTemperatureUnit(data.hourly.data[i].temperature, unit);
					var apparentTemperature = checkTemperatureUnit(data.hourly.data[i].apparentTemperature, unit);
					var time = convertUnixToHumanTime(data.hourly.data[i].time);
					var windDirection = getWindDirection(data.hourly.data[i].windBearing); //convert to direction! 
					var icon = data.hourly.data[i].icon; 
					var iconClass = getIconClass(iconClass, data.hourly.data[i].time, data.daily.data[0].sunsetTime, true)

					//set the html for all the boxes
					$('#time-' + (i+1)).html(time);
					$('#temperature-' + (i+1)).html(temperature + '&deg;' + unit);
					$('#hourly-icon-' + (i+1)).find('div').removeClass().addClass('weather-icon').addClass(iconClass);
					$('#feels-like-' + (i+1)).html(apparentTemperature + '&deg;' + unit); 
					$('#precipitation-' + (i+1)).html(data.hourly.data[i].precipProbability + '%');
					$('#humidity-' + (i+1)).html(data.hourly.data[i].humidity*100 + '%');
					$('#wind-speed-' + (i+1)).html(Math.round(data.hourly.data[i].windSpeed) + ' mph ' + windDirection);
				}
			}
		});	
	}
	//darksky api returns all times in unix time - so convert them! 
	convertUnixToHumanTime = function(unixTime){
		var hour = new Date(unixTime*1000).getHours();
		var minute = new Date(unixTime*1000).getMinutes();
		if (minute < 10) minute = '0' + minute;
		var time = hour;
		if (time === 0) time = 12 + ':' + minute + 'AM';
		else if (time < 12) time = time + ':' + minute + ' AM';
		else if (time === 12) time = time + ':' + minute + 'PM'
		else time = time%12 + ':' + minute + 'PM';
		return time;
	}

	//check the unit and convert to celcius if needed
	checkTemperatureUnit = function(temperature, unit){
		var newTemp = temperature;
		if (unit == 'C'){
			newTemp = (temperature - 32)*5/9;
		}
		return Math.round(newTemp);
	}

	//won't be using this one...
	populate3HourData = function(result, apiUnit, unit) {
		$.ajax({
			url: 'http://api.openweathermap.org/data/2.5/forecast',
			async: false,
			cache: false,
			dataType: 'xml',
			data: {
				lat: result.latitude,
				lon: result.longitude,
				cnt: 5,
				units: apiUnit,
				mode: 'xml',
				appid: '3b41a386edad3e3156564ca59767fcc6'
			},
			success: function(weatherData) {
				var sunriseTime = convertDateTimeStringToDate($(weatherData).find('sun').attr('rise'));
				var sunsetTime = convertDateTimeStringToDate($(weatherData).find('sun').attr('set'));

				$('#sunrise-text').html(formatTime(sunriseTime));
				$('#sunset-text').html(formatTime(sunsetTime));

				$(weatherData).find('forecast').find('time').each(function(index, element) {
					if (index >= 5) {
						return false;
					}

					var i = index + 1;
					var time = convertDateTimeStringToDate($(element).attr('from'));
					var temperature = Math.round(parseFloat($(element).find('temperature').attr('value'))).toString();
					var iconClass = getIconClass($(element).find('symbol').attr('number'), time, sunsetTime, false);
					var precipitation = getPrecipitationPercentage($(element).find('precipitation').attr('value'));
					var humidity = $(element).find('humidity').attr('value');
					var windSpeed = Math.round(parseFloat($(element).find('windSpeed').attr('mps')) * 3600 / 1609.244);
					var windDirection = $(element).find('windDirection').attr('code');

					$('#time-' + i).html(formatTime(time));
					$('#temperature-' + i).html(temperature + '&deg;' + unit);
					$('#hourly-icon-' + i).find('div').removeClass().addClass('weather-icon').addClass(iconClass);
					$('#feels-like-' + i).html($('#temperature-' + i).html()); /* Use temperature value because the free API does not have feels like temperature available */
					$('#precipitation-' + i).html(precipitation + '%');
					$('#humidity-' + i).html(humidity + '%');
					$('#wind-speed-' + i).html(windSpeed.toString() + ' mph ' + windDirection);

					if (index == 0) {
						$('#date-text').html(formatDate(time));
						$('#current-temperature-text').html($('#temperature-' + i).html());

						<?php if (is_numeric($userID)) { ?>
							populateFeelData(temperature);
						<?php } ?>
					}
				});
			}
		});
	}

	populate5DayData = function(result, apiUnit, unit) {
		$.ajax({
			url: 'http://api.openweathermap.org/data/2.5/forecast/daily',
			async: false,
			cache: false,
			dataType: 'xml',
			data: {
				lat: result.latitude,
				lon: result.longitude,
				units: apiUnit,
				cnt: 5,
				mode: 'xml',
				appid: '3b41a386edad3e3156564ca59767fcc6'
			},
			success: function(weatherData) {
				$(weatherData).find('forecast').find('time').each(function(index, element) {
					if (index >= 5) {
						return false;
					}

					var i = index + 1;
					var date = convertDateStringToDate($(element).attr('day'));
					var minTemperature = Math.round(parseFloat($(element).find('temperature').attr('min'))).toString();
					var maxTemperature = Math.round(parseFloat($(element).find('temperature').attr('max'))).toString();
					var iconClass = getIconClass($(element).find('symbol').attr('number'), '', '', false);

					$('#day-' + i).html(formatDay(date));
					$('#high-low-' + i).html(maxTemperature + '&deg;' + unit + ' / ' + minTemperature + '&deg;' + unit);
					$('#future-icon-' + i).find('div').removeClass().addClass('weather-icon').addClass(iconClass);
				});
			}
		});
	}

	populateFeelData = function(temperature) {
		$.ajax({
			url: '<?php echo URL_WITH_INDEX_FILE; ?>feels/getFeelsByTemperature/' + temperature,
			cache: false,
			method: 'POST',
			dataType: 'json',
			success: function(feels) {
				var feelID = '';
				var feelText = [];
				var bringText = [];

				$(feels).each(function(index, feel) {
					if (index == 0) {
						feelID = feel.ID;
					}

					if (feel.Description != null && feelText.indexOf(feel.Description) < 0) {
						feelText.push(feel.Description);
					}

					if (feel.Bring_Wear != null && bringText.indexOf(feel.Bring_Wear) < 0) {
						bringText.push(feel.Bring_Wear);
					}
				});

				var hideEditLink = true;
				if (feelText.length > 0) {
					$('#feel-text').html(feelText.join(', '));
					$('#edit-feel').attr('href', '<?php echo URL_WITH_INDEX_FILE; ?>feels/edit/' + feelID);
					$('#edit-feel').after('<br/>');
					hideEditLink = false;
				}
				else {
					$('#feel-text').hide();
				}

				if (bringText.length > 0) {
					$('#bring-text').html('Bring / Wear: ' + bringText.join(', '));
					if (hideEditLink) {
						var editLink = $('#edit-feel').detach();
						$('#bring-text').after(editLink);
						$('#edit-feel').attr('href', '<?php echo URL_WITH_INDEX_FILE; ?>feels/edit/' + feelID);
						$('#edit-feel').after('<br/>');
						hideEditLink = false;
					}
					else {
						$('#bring-text').after('<br/>');
					}
				}
				else {
					$('#bring-text').hide();
				}

				if (hideEditLink) {
					$('#edit-feel').hide();
				}
			}
		});
	}

	convertDateTimeStringToDate = function(text) {
		return new Date(text+'Z');
	}

	convertDateStringToDate = function(text) {
		var dateArray = text.split('-');
		return new Date(parseInt(dateArray[0]), parseInt(dateArray[1]) - 1, parseInt(dateArray[2]), 0, 0, 0, 0);
	}

	getIconClass = function(conditionID, currentTime, sunsetTime, darksky) {
		var iconClass = '';
		console.log(conditionID);
		if(!darksky){
			switch (conditionID.substr(0,1)) {
				case '2':
					iconClass = 'storm';
					break;
				case '3', '5':
					iconClass = 'rain';
					break;
				case '6':
					iconClass = 'snow';
					break;
			}
			//for openweatherapi: numerical
			if (iconClass == '') {
				if (conditionID == '960' && conditionID == '961') {
					iconClass = 'storm';
				}
				else if (conditionID.substr(0,2) == '80' && conditionID != '800') {
					iconClass = 'cloud';
				}
				else if (currentTime != '' && sunsetTime != '' & currentTime > sunsetTime) {
					iconClass = 'moon';
				}
				else {
					iconClass = 'sun';
				}
			}
		}
		//for darksky: clear-day, clear-night, rain, snow, sleet, wind, fog, cloudy, partly-cloudy-day, or partly-cloudy-night
		if (darksky && iconClass == '') {
			if (conditionID == 'clear-night' || currentTime > sunsetTime){
				iconClass = 'moon';
			}
			else if (conditionID == 'rain'){
				iconClass = 'rain';
			} 
			else if (conditionID == 'snow' || conditionID == 'sleet'){
				iconClass = 'snow';
			}
			//else if (conditionID == 'wind'){
			//	iconClass = 'wind';
			//} 
			else if (conditionID == 'fog' || conditionID == 'cloudy' || conditionID == 'partly-cloudy-night' || conditionID == 'partly-cloudy-day'){
				iconClass = 'cloud';
			}
			else iconClass = 'sun';
		}

		return iconClass;
	}

	formatTime = function(dateTime) {
		var timeFormat = '<?php echo $GLOBALS["beans"]->siteHelper->getSession("timeFormat"); ?>';
		var result;

		var minuteText = '00' + dateTime.getMinutes().toString();
		minuteText = minuteText.substr(minuteText.length - 2, 2);

		if (timeFormat == '24') {
			var hourText = '00' + dateTime.getHours().toString();
			hourText = hourText.substr(hourText.length - 2, 2);
			result = hourText + ':' + minuteText; 
		}
		else {
			var hour = dateTime.getHours() % 12;
			if (hour == 0) {
				hour = 12;
			}
			hourText = '00' + hour.toString();
			hourText = hourText.substr(hourText.length - 2, 2);

			var am_pm = 'AM';
			if (dateTime.getHours() >= 12) {
				am_pm = 'PM';
			}

			result = hourText + ':' + minuteText + ' ' + am_pm;
		}

		return result;
	}

	formatDate = function(dateTime) {
		var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		return monthNames[dateTime.getMonth()] + ' ' + dateTime.getDate().toString() + ', ' + dateTime.getFullYear().toString();
	}

	formatDay = function(dateTime) {
		var dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
		return dayNames[dateTime.getDay()];
	}

	/* Fake precipitation data since the free API does not have precipitation percentage available - shouldn't need this anymore*/
	getPrecipitationPercentage = function(value) {
		var result = 0;

		if ($.isNumeric(value)) {
			result = Math.ceil(parseFloat(value) * 10);
			if (result > 100) {
				result = 100;
			}
		}

		return result;
	}
	function getWindDirection(windBearing){
		var dir = '';
		if (windBearing >= 348.75 || windBearing <= 11.25) dir = 'N';
		else if (windBearing > 11.25 && windBearing <= 33.75) dir = 'NNE';
		else if (windBearing > 33.75 && windBearing <= 56.25) dir = 'NE';
		else if (windBearing > 56.25 && windBearing <= 78.75) dir = 'ENE';
		else if (windBearing > 78.75 && windBearing <= 101.25) dir = 'E';
		else if (windBearing > 101.25 && windBearing <= 123.75) dir = 'ESE';
		else if (windBearing > 123.75 && windBearing <= 146.25) dir = 'SE';
		else if (windBearing > 146.25 && windBearing <= 168.75) dir = 'SSE';
		else if (windBearing > 168.75 && windBearing <= 191.25) dir = 'S';
		else if (windBearing > 191.25 && windBearing <= 213.75) dir = 'SSW';
		else if (windBearing > 213.75 && windBearing <= 236.25) dir = 'SW';
		else if (windBearing > 236.25 && windBearing <= 258.75) dir = 'WSW';
		else if (windBearing > 258.75 && windBearing <= 281.25) dir = 'W';
		else if (windBearing > 281.25 && windBearing <= 303.75) dir = 'WNW';
		else if (windBearing > 303.75 && windBearing <= 326.25) dir = 'NW';
		else dir = 'NNW';
		return dir;
	}
</script>