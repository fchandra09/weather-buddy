<?php

class FeelService extends Service
{

	public function getFeels($userID)
	{
		return $this->model->getFeels($userID);
	}

	public function getFeel($feelID, $userID = "")
	{
		return $this->model->getFeel($feelID, $userID);
	}

	public function saveFeel()
	{
		$feelID = $_POST["feelID"];

		if (is_numeric($feelID)) {
			$this->model->updateFeel();
		}
		else {
			$feelID = $this->model->insertFeel(
					$_POST["userID"],
					$_POST["description"],
					$_POST["bringWear"],
					$GLOBALS["beans"]->siteHelper->getSession("temperatureUnit"),
					$_POST["minTemperature"],
					$_POST["maxTemperature"]
			);
		}

		return $feelID;
	}

	public function deleteFeel($feelID, $userID)
	{
		$this->model->deleteFeel($feelID, $userID);
	}

	public function getFeelsByTemperature($temperature)
	{
		$result = "";

		if (is_numeric($temperature)) {
			$result = $this->model->getFeelsByTemperature($temperature);
		}

		return $result;
	}

	public function presetDefaultFeels($userID)
	{
		$this->model->insertFeel($userID, "Hot", "", "F", "70", "130");
		$this->model->insertFeel($userID, "Warm", "", "F", "50", "70");
		$this->model->insertFeel($userID, "Chilly", "Thin sweater", "F", "30", "50");
		$this->model->insertFeel($userID, "Cold", "Thick jacket", "F", "0", "30");
		$this->model->insertFeel($userID, "Super cold", "Thick jacket", "F", "-30", "0");
	}
}