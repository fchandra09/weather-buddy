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
	
				$('#needSomeBODY').append(
					'<tr><td>'+time+'</td>'+
			            	'<td></td>'+ //icon
			            	'<td>'+hourly[i].temperature+'&deg;'+unit+'</td>'+
			            	'<td>'+hourly[i].apparentTemperature+'&deg;'+unit+'</td>'+
			            	'<td>'+hourly[i].precipProbability*100+'%</td>'+
			            	'<td>'+hourly[i].humidity*100+'%</td>'+
			            	'<td>'+hourly[i].windSpeed+'</td></tr>');
				
			    var temp = Math.round(hourly[i].temperature).toString();
			    allTemps.push(temp);
		    }      
		}
		fillBrings(allTemps);
	}
	function fillBrings(temps){
		for (var i = 0; i < temps.length; i++){
			getBringData(temps[i]);
		}
		/*if (bringText.length > 0) {
			$('#bring-text').html('Bring / Wear: ' + bringText.join(', '));
		}*/
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
	function getBringData(temperature){
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
					if (currBringText.search(bringText.join(',')) == -1) //fix if more than one thing to bring
						$('#bring-text').append(bringText.join(', '));
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
		var month = new Array();
		month[0] = "January";
		month[1] = "February";
		month[2] = "March";
		month[3] = "April";
		month[4] = "May";
		month[5] = "June";
		month[6] = "July";
		month[7] = "August";
		month[8] = "September";
		month[9] = "October";
		month[10] = "November";
		month[11] = "December";
		return month[monthNum];
	}

</script>