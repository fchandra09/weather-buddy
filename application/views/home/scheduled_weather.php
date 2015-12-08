<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>
<html>
<div class="container">
	<div class="clearfix">
		<div class="location">
			<span id="location-text">Champaign, IL 61820</span><br/>
			<span id="date-text"></span>
		</div>
	</div>

	<div class="main-link">
		<a href="<?php echo URL_WITH_INDEX_FILE; ?>home/today">
			See Today's Weather
			<span class="glyphicon glyphicon-chevron-right"></span>
		</a>
	</div>

	<div class="welcome text-center">Welcome, <?php echo $user->First_Name ?>!</div>
	<div class="important-info text-center">
		<span id="mySchedule">No times chosen</span>
		<span id="scheduleStart" class="hidden"></span><span id="scheduleEnd" class="hidden"></span>
		<a id="edit-schedule" href="#" title="Edit" class="edit-link">
			<span class="glyphicon glyphicon-pencil"></span>
		</a>
	</div>
	<div class="additional-info text-center">
		Bring / Wear: <span id="bring-text"><span>
	</div>
	
	<div class="panel panel-default weather-details">
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th>Time</th>
							<th>Temperature</th>
							<th>Feel</th>
							<th>Precipitation</th>
							<th>Humidity</th>
							<th>Wind Speed</th>
						</tr>
					</thead>
					<tbody id="needSomeBODY">
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</html>
<script>
	$(document).ready(function() {
		//Taken from Felicia's code at today_weather.php
		<?php if (strcasecmp($GLOBALS["beans"]->siteHelper->getSession("temperatureUnit"), "C") == 0) { ?>
			//var apiUnit = 'metric';
			var unit = 'C';
		<?php } else { ?>
			//var apiUnit = 'imperial';
			var unit = 'F';
		<?php } ?>

		// Set time according to user's timezone
		var localTime  = moment.utc().toDate();
		localTime = moment(localTime).format('MMMM D, YYYY');
		$('#date-text').html(localTime);

		getCurrentSchedule();

		//Call APIs to get location and hourly weather data
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
				success: function(location) {
					saveDefaultLocationToSession(result);
				}
			});
		<?php } ?>

		if ($('#scheduleStart').text() != '') {
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
					$.getJSON("https://api.forecast.io/forecast/0e5e272af26d7da6b94ffd58bf3b7f7a/"+result.latitude+","+result.longitude+"?callback=?", function(data){
						console.log("FORECAST DATA");
						console.log(data);
						if(data.hourly){
							fill(data.hourly.data, unit, data.daily.data[0].sunsetTime);
						}
					});			
				}
			});
		}
	});

	getCurrentSchedule = function() {
		var localTime  = moment.utc().toDate();
		var currentDayNumber = moment(localTime).day();
		var currentTime = moment(localTime).format('HH:mm:ss');

		$.ajax({
			url: '<?php echo URL_WITH_INDEX_FILE; ?>schedule/getCurrentSchedule/' + currentDayNumber + '/' + currentTime,
			async: false,
			cache: false,
			method: 'POST',
			dataType: 'json',
			success: function(result) {
				if (result.ID != '') {
					var timeFormat = '<?php echo $GLOBALS["beans"]->siteHelper->getSession("timeFormat"); ?>';

					var start = result.Start_Time_12;
					var end = result.End_Time_12;
					if (timeFormat == '24') {
						start = result.Start_Time_24;
						end = result.End_Time_24;
					}

					$('#mySchedule').html(result.Display_Day + ' ' + start + ' - ' + end);
					$('#edit-schedule').attr('href', '<?php echo URL_WITH_INDEX_FILE; ?>schedule/edit/' + result.ID);
					$('#scheduleStart').html(result.Start_Time_12);
					$('#scheduleEnd').html(result.End_Time_12);
				}
				else {
					$('.additional-info').html('Please set your schedule under the Schedule Settings');
					$('#edit-schedule').hide();
				}
			}
		});
	}

	function fill(hourly,unit, sunsetTime){
		var start = getStartEndTime("start");
		var end = getStartEndTime("end");
		var time = '';
		var bringText = [];
		for (var i = 0; i < hourly.length; i++){
			if(hourly[i].time >= start & hourly[i].time <= end){
				time = formatTime(hourly[i].time);

				var windBearing = getWindDirection(hourly[i].windBearing);
				var temperature = checkTemperatureUnit(hourly[i].temperature, unit);
				var feelsTemp = checkTemperatureUnit(hourly[i].apparentTemperature,unit);

				var feelText = '';
				var feelsData = getFeelsData(feelsTemp, bringText);
				if (feelsData.length > 0) {
					feelText = feelsData[0];
					bringText = feelsData[1];
				}

				var icon = hourly[i].icon; 
				var iconClass = getIconClass(icon, hourly[i].time, sunsetTime);

				$('#needSomeBODY').append(
					'<tr><td class="text-center"><div class="weather-icon ' + iconClass + '" style="display:inline-block;"></div></td>'+
			            	'<td>'+time+'</td>'+
			            	'<td>'+temperature+'&deg;'+unit+'</td>'+
			            	'<td>'+feelText+'</td>'+
			            	'<td>'+hourly[i].precipProbability*100+'%</td>'+
			            	'<td>'+hourly[i].humidity*100+'%</td>'+
			            	'<td>'+Math.round(hourly[i].windSpeed)+' mph '+windBearing+'</td></tr>');
		    }      
		}

		// Check if umbrella is necessary
		if ($('div.weather-icon.rain').length > 0) {
			bringText.push('Umbrella');
		}
		if (bringText.length > 0) {
			$('#bring-text').html(bringText.join(', '));
		}
		else {
			$('.additional-info').hide();
		}
	}

	function getStartEndTime(time){
		var start = $('#scheduleStart').text();
		var end = $('#scheduleEnd').text();

		var startUnix = 0;
		var endUnix = 0;
		var rightNow = Math.round((new Date()).getTime() / 1000);

		//convert into UNIX time for fun (jk we need to be able to get the right hours)
		if (start.substring(start.length-2, start.length) === "AM"){
			//console.log("AM");
			start = start.substr(0,2);
			today = new Date(); //get today's date
			myDate = getMonthName(today.getMonth()) + ' ' + today.getDate() + ', ' + today.getFullYear() + ' ' + start + ':00:00';
			startUnix = Math.round((new Date(myDate)).getTime() / 1000);
		} else {
			//console.log("PM");
			startnum = Number(start.substr(0,2));
			if (startnum != 12) {
				startnum = startnum + 12;
			}
			startnum = String(startnum); //convert start back to 24hr time
			today = new Date(); //get today's date
			myDate = getMonthName(today.getMonth()) + ' ' + today.getDate() + ', ' + today.getFullYear() + ' ' + startnum + ':00:00';
			startUnix = Math.round((new Date(myDate)).getTime() / 1000);
		}
		//same thing for end - repeating code is bad I know, I'll fix later if time
		if (end.substring(end.length-2, end.length) === "AM"){
			//console.log("AM");
			var endMin = end.substr(3,2);
			end = end.substr(0,2);
			if (endMin != '00') {
				end = parseInt(end) + 1;
				end = '00' + end;
				end = end.substr(end.length - 2, 2);
			}
			today = new Date(); //get today's date
			myDate = getMonthName(today.getMonth()) + ' ' + today.getDate() + ', ' + today.getFullYear() + ' ' + end + ':00:00';
			endUnix = Math.round((new Date(myDate)).getTime() / 1000);
		} else {
			//console.log("PM");
			var endMin = end.substr(3,2);
			endnum = Number(end.substr(0,2));
			if (endnum != 12) {
				endnum = endnum + 12;
			}
			endnum = String(endnum); //convert start back to 24hr time
			if (endMin != '00') {
				endnum = parseInt(endnum) + 1;
				if (endnum > 23) {
					endnum = 0;
				}
				endnum = '00' + endnum;
				endnum = endnum.substr(endnum.length - 2, 2);
			}
			today = new Date(); //get today's date
			myDate = getMonthName(today.getMonth()) + ' ' + today.getDate() + ', ' + today.getFullYear() + ' ' + endnum + ':00:00';
			endUnix = Math.round((new Date(myDate)).getTime() / 1000);
		}
		if (startUnix < rightNow){
			//console.log("show me tomorrow!");
			var oneDay = 24*60*60;
			startUnix += oneDay;
			endUnix += oneDay;
		}
		if(time === "start") return startUnix;
		if(time === "end") return endUnix;
		//to deal with later: multiple time periods?? checking to make sure it's the day wanted?

	}
	function getFeelsData(temperature, bringText){
		var result = [];

		$.ajax({
			url: '<?php echo URL_WITH_INDEX_FILE; ?>feels/getFeelsByTemperature/' + temperature,
			async: false,
			cache: false,
			method: 'POST',
			dataType: 'json',
			success: function(feels) {
				var feelText = [];

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

				result.push(feelText.join(', '));
				result.push(bringText);
			}
		});

		return result;
	}

	//same as today_weather.php
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
	
	//Because javascript data objects need help sometimes
	function getMonthName(monthNum){
		var month = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		return month[monthNum];
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
	//check the unit and convert to celcius if needed
	checkTemperatureUnit = function(temperature, unit){
		var newTemp = temperature;
		if (unit == 'C'){
			newTemp = (temperature - 32)*5/9;
		}
		return Math.round(newTemp);
	}

	getIconClass = function(conditionID, currentTime, sunsetTime) {
		var iconClass = '';

		//for darksky: clear-day, clear-night, rain, snow, sleet, wind, fog, cloudy, partly-cloudy-day, or partly-cloudy-night
		if (conditionID == 'clear-night' || currentTime > sunsetTime){
			iconClass = 'moon';
		}
		else if (conditionID == 'rain'){
			iconClass = 'rain';
		} 
		else if (conditionID == 'snow' || conditionID == 'sleet'){
			iconClass = 'snow';
		}
		else if (conditionID == 'fog' || conditionID == 'cloudy' || conditionID == 'partly-cloudy-night' || conditionID == 'partly-cloudy-day'){
			iconClass = 'cloud';
		}
		else iconClass = 'sun';

		return iconClass;
	}

	formatTime = function(unixTime) {
		var dateTime = new Date(unixTime * 1000);
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
</script>