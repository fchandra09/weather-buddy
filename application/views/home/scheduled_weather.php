<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>
<html>
<div class="container">
	<div class="clearfix">
		<div class="location">
			<span id="location-text">Champaign, IL 61820</span><br/>
			<span id="date-text"><?php echo date('F d, Y', time()); ?></span>
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
							<th>Time</th>
							<th>&nbsp;</th>
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
						fill(data.hourly.data, unit);
					}
				});			
			}
		});
	});

	function fill(hourly,unit){
		var start = getStartEndTime("start");
		var end = getStartEndTime("end");
		var time = '';
		var allTemps = [];
		for (var i = 0; i < hourly.length; i++){
			if(hourly[i].time >= start & hourly[i].time <= end){
				time = new Date(hourly[i].time*1000).getHours();
				if (time === 0) time = 12+':00 AM';
				else if (time < 12) time = time+':00 AM';
				else if (time === 12) time = time+':00 PM'
				else time = time%12 +':00 PM';

				var windBearing = getWindDirection(hourly[i].windBearing);
				var temperature = checkTemperatureUnit(hourly[i].temperature, unit);
				var feelsTemp = checkTemperatureUnit(hourly[i].apparentTemperature,unit);
				$('#needSomeBODY').append(
					'<tr><td>'+time+'</td>'+
			            	'<td></td>'+ //icon
			            	'<td>'+temperature+'&deg;'+unit+'</td>'+
			            	'<td>'+feelsTemp+'&deg;'+unit+'</td>'+
			            	'<td>'+hourly[i].precipProbability*100+'%</td>'+
			            	'<td>'+hourly[i].humidity*100+'%</td>'+
			            	'<td>'+Math.round(hourly[i].windSpeed)+' mph '+windBearing+'</td></tr>');
				
			    var temp = Math.round(feelsTemp).toString();
			    allTemps.push(temp);
		    }      
		}
		fillBrings(allTemps);
	}
	function fillBrings(temps){
		for (var i = 0; i < temps.length; i++){
			getBringData(temps[i],i);
		}
	}
	function getStartEndTime(time){
		var start = "";
		var end = "";
		//first, get the start and end times
		<?php $scheduleList = $GLOBALS["beans"]->scheduleService->getScheduleList($userID); ?>
		<?php foreach ($scheduleList as $schedule){ ?>
			<?php if (strcasecmp($GLOBALS["beans"]->siteHelper->getSession("timeFormat"), "24") == 0) { ?>
				start = "<?php echo $schedule->Start_Time_24 ?>";
				end = "<?php echo $schedule->End_Time_24 ?>";
			<?php } else { ?>
				start = "<?php echo $schedule->Start_Time_12 ?>";
				end = "<?php echo $schedule->End_Time_12 ?>";
			<?php } ?>
		<?php } ?>
		//console.log("start is "+start+" end is "+end);
		$('#mySchedule').html(start + '-' + end);
		$('#edit-schedule').attr('href', '<?php echo URL_WITH_INDEX_FILE; ?>schedule/edit/1');
		var startUnix = 0;
		var endUnix = 0;
		var rightNow = Math.round((new Date()).getTime() / 1000);
		
		//convert into UNIX time for fun (jk we need to be able to get the right hours)
		if (start.substring(start.length-2, start.length) === "AM"){
			//console.log("AM");
			start = start.substring(0,5);
			today = new Date(); //get today's date
			myDate = getMonthName(today.getMonth()) + ' ' + today.getDate() + ', ' + today.getFullYear() + ' ' + start + ':00';
			startUnix = Math.round((new Date(myDate)).getTime() / 1000);
		} else {
			//console.log("PM");
			startnum = String(Number(start.substring(0,2))+12); //convert start back to 24hr time
			start = startnum+start.substring(2,5);
			today = new Date(); //get today's date
			myDate = getMonthName(today.getMonth()) + ' ' + today.getDate() + ', ' + today.getFullYear() + ' ' + start + ':00';
			startUnix = Math.round((new Date(myDate)).getTime() / 1000);
		}
		//same thing for end - repeating code is bad I know, I'll fix later if time
		if (end.substring(end.length-2, end.length) === "AM"){
			//console.log("AM");
			end = end.substring(0,5);
			today = new Date(); //get today's date
			myDate = getMonthName(today.getMonth()) + ' ' + today.getDate() + ', ' + today.getFullYear() + ' ' + end + ':00';
			endUnix = Math.round((new Date(myDate)).getTime() / 1000);
		} else {
			//console.log("PM");
			endnum = String(Number(end.substring(0,2))+12); //convert start back to 24hr time
			end = endnum+end.substring(2,5);
			today = new Date(); //get today's date
			myDate = getMonthName(today.getMonth()) + ' ' + today.getDate() + ', ' + today.getFullYear() + ' ' + end + ':00';
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
	function getBringData(temperature, tempindex){
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
				if (bringText.length > 0) {
					var currBringText = $('#bring-text').html();
					if (currBringText.search(bringText[0]) === -1){
						if (tempindex > 0) $('#bring-text').append(', ');
						$('#bring-text').append(bringText[0]);
					}
				}
				
				return bringText;
			}
		});
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


</script>