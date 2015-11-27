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
			$feelID = $this->model->insertFeel();
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

}