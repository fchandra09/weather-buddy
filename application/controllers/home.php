<?php

/**
 * Class Home
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Home
{

	public function index()
	{
		$userID = $GLOBALS["beans"]->siteHelper->getSession("userID");
		$homeScreen = $GLOBALS["beans"]->siteHelper->getSession("homeScreen");

		if (is_numeric($userID) && strcasecmp($homeScreen, "Schedule") == 0) {
			$this->scheduled();
		}
		else {
			$this->today();
		}
	}

	public function today()
	{
		require APP . 'views/_templates/header.php';
		require APP . 'views/home/today_weather.php';
		require APP . 'views/_templates/footer.php';
	}

	public function scheduled()
	{
		require APP . 'views/_templates/header.php';
		require APP . 'views/home/scheduled_weather.php';
		require APP . 'views/_templates/footer.php';
	}

	public function setDefaultLocation($city, $region, $country, $zip, $latitude, $longitude, $timezone) {
		$_SESSION["location"] = new stdClass();
		$_SESSION["location"]->city = urldecode($city);
		$_SESSION["location"]->region = urldecode($region);
		$_SESSION["location"]->country = urldecode($country);
		$_SESSION["location"]->zip = urldecode($zip);
		$_SESSION["location"]->latitude = urldecode($latitude);
		$_SESSION["location"]->longitude = urldecode($longitude);
		$_SESSION["location"]->timezone = urldecode($timezone);
	}

	public function getDefaultLocation() {
		$location = $GLOBALS["beans"]->siteHelper->getSession("location");

		if (!is_object($location)) {
			$_SESSION["location"] = new stdClass();
			$_SESSION["location"]->city = "Urbana";
			$_SESSION["location"]->region = "Illinois";
			$_SESSION["location"]->country = "United States";
			$_SESSION["location"]->zip = "61801";
			$_SESSION["location"]->latitude = "40.114254";
			$_SESSION["location"]->longitude = "-88.224818";
			$_SESSION["location"]->timezone = "-06:00";
		}

		echo json_encode($location);
	}

}
