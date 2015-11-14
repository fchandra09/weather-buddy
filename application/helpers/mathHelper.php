<?php

class MathHelper
{

	public function convertFahrenheitToCelsius($value)
	{
		return round(($value - 32) * 5 / 9);
	}

	public function convertCelsiusToFahrenheit($value)
	{
		return round(($value * 9 / 5) + 32);
	}

}