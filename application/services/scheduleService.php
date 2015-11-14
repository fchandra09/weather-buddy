<?php

class ScheduleService extends Service
{

	public function getScheduleList($userID)
	{
		return $this->model->getScheduleList($userID);
	}
	
	public function getSchedule($scheduleID, $userID = "")
	{
		return $this->model->getSchedule($scheduleID, $userID);
	}
	
	public function saveSchedule()
	{
		$scheduleID = $_POST["scheduleID"];
	
		if (is_numeric($scheduleID)) {
			$this->model->updateSchedule();
		}
		else {
			$scheduleID = $this->model->insertSchedule();
		}
	
		return $scheduleID;
	}
	
	public function deleteSchedule($scheduleID, $userID)
	{
		$this->model->deleteSchedule($scheduleID, $userID);
	}

}