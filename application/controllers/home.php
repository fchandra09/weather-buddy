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
}
