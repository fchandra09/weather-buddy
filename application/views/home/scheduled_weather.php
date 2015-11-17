<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); } ?>

<div class="container">
	<div class="location">
		Champaign, IL 61820<br/>
		November 17, 2015
	</div>

	<div class="welcome text-center">Welcome, Jane!</div>
	<div class="important-info text-center">
		Monday 11:00 AM - 2:00 PM
		<span class="glyphicon glyphicon-pencil"></span>
	</div>
	<div class="additional-info text-center">
		Bring / Wear: Sleeveless, Light Clothing, Umbrella
	</div>

	<div class="panel panel-default weather-details">
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>Time</th>
							<th width="1%">&nbsp;</th>
							<th>Temperature</th>
							<th>Feel</th>
							<th>Precipitation</th>
							<th>Humidity</th>
							<th>Wind Speed</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>11:00 AM</td>
							<td><i class="fa fa-sun-o"></i></td>
							<td>83&deg;F</td>
							<td>Scorching hot</td>
							<td>70%</td>
							<td>40%</td>
							<td>8 mph W</td>
						</tr>
						<tr>
							<td>12:00 PM</td>
							<td><i class="fa fa-cloud"></i></td>
							<td>75&deg;F</td>
							<td>Warm</td>
							<td>80%</td>
							<td>54%</td>
							<td>8 mph W</td>
						</tr>
						<tr>
							<td>1:00 PM</td>
							<td><i class="fa fa-cloud"></i></td>
							<td>70&deg;F</td>
							<td>Warm</td>
							<td>95%</td>
							<td>72%</td>
							<td>12 mph W</td>
						</tr>
						<tr>
							<td>2:00 PM</td>
							<td><i class="fa fa-tint"></i></td>
							<td>69&deg;F</td>
							<td>Warm</td>
							<td>100%</td>
							<td>80%</td>
							<td>17 mph W</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="main-link text-right">
		See Today's Weather
	</div>
</div>