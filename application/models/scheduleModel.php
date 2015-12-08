<?php

class ScheduleModel extends Model
{

	public function getScheduleList($userID)
	{
		$sql = "SELECT Schedule.*,
					TIME_FORMAT(Schedule.Start_Time, '%h:%i %p') AS Start_Time_12,
					TIME_FORMAT(Schedule.End_Time, '%h:%i %p') AS End_Time_12,
					TIME_FORMAT(Schedule.Start_Time, '%H:%i') AS Start_Time_24,
					TIME_FORMAT(Schedule.End_Time, '%H:%i') AS End_Time_24
				FROM Schedule
				WHERE Schedule.User_ID = :user_id
				ORDER BY Schedule.Monday DESC, Schedule.Tuesday DESC, Schedule.Wednesday DESC, Schedule.Thursday DESC,
					Schedule.Friday DESC, Schedule.Saturday DESC, Schedule.Sunday DESC, Schedule.Start_Time, Schedule.End_Time";

		$parameters = array(":user_id" => $userID);

		$query = $this->db->prepare($sql);
		$query->execute($parameters);

		return $query->fetchAll();
	}

	public function getSchedule($scheduleID, $userID = "")
	{
		$sql = "SELECT Schedule.*,
					TIME_FORMAT(Schedule.Start_Time, '%h:%i %p') AS Start_Time_12,
					TIME_FORMAT(Schedule.End_Time, '%h:%i %p') AS End_Time_12,
					TIME_FORMAT(Schedule.Start_Time, '%H:%i') AS Start_Time_24,
					TIME_FORMAT(Schedule.End_Time, '%H:%i') AS End_Time_24
				FROM Schedule
				WHERE Schedule.ID = :schedule_id";
		if (is_numeric($userID)) {
			$sql .= " AND Schedule.User_ID = :user_id";
		}

		$parameters = array(':schedule_id' => $scheduleID);
		if (is_numeric($userID)) {
			$parameters[":user_id"] = $userID;
		}

		return $GLOBALS["beans"]->queryHelper->getSingleRowObject($this->db, $sql, $parameters);
	}

	public function insertSchedule() {
		$sql = "INSERT INTO Schedule (User_ID, Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, Sunday, Start_Time, End_Time, Created_On, Modified_On)
				VALUES (:user_id, :monday, :tuesday, :wednesday, :thursday, :friday, :saturday, :sunday, ";

		if (strcasecmp($GLOBALS["beans"]->siteHelper->getSession("timeFormat"), "24") == 0) {
			$sql .= "STR_TO_DATE(:start_time, '%H:%i'), STR_TO_DATE(:end_time, '%H:%i')";
		}
		else {
			$sql .= "STR_TO_DATE(:start_time, '%h:%i %p'), STR_TO_DATE(:end_time, '%h:%i %p')";
		}

		$sql .= ", NOW(), NOW())";

		$parameters = array(
				":user_id" => $_POST["userID"],
				":start_time" => $_POST["startTime"],
				":end_time" => $_POST["endTime"]
		);

		foreach (explode(",", "monday,tuesday,wednesday,thursday,friday,saturday,sunday") as $day) {
			$key = ":" . $day;
			if (array_key_exists($day, $_POST)) {
				$parameters[$key] = 1;
			}
			else {
				$parameters[$key] = 0;
			}
		}

		return $GLOBALS["beans"]->queryHelper->executeWriteQuery($this->db, $sql, $parameters);
	}

	public function updateSchedule() {
		$sql = "UPDATE Schedule
				SET Monday = :monday,
					Tuesday = :tuesday,
					Wednesday = :wednesday,
					Thursday = :thursday,
					Friday = :friday,
					Saturday = :saturday,
					Sunday = :sunday,";

		if (strcasecmp($GLOBALS["beans"]->siteHelper->getSession("timeFormat"), "24") == 0) {
			$sql .= "Start_Time = STR_TO_DATE(:start_time, '%H:%i'),
					End_Time = STR_TO_DATE(:end_time, '%H:%i'),";
		}
		else {
			$sql .= "Start_Time = STR_TO_DATE(:start_time, '%h:%i %p'),
					End_Time = STR_TO_DATE(:end_time, '%h:%i %p'),";
		}
		
		$sql .= "Modified_On = NOW()
				WHERE Schedule.ID = :schedule_id
					AND Schedule.User_ID = :user_id";

		$parameters = array(
				":schedule_id" => $_POST["scheduleID"],
				":user_id" => $_POST["userID"],
				":start_time" => $_POST["startTime"],
				":end_time" => $_POST["endTime"]
		);

		foreach (explode(",", "monday,tuesday,wednesday,thursday,friday,saturday,sunday") as $day) {
			$key = ":" . $day;
			if (array_key_exists($day, $_POST)) {
				$parameters[$key] = 1;
			}
			else {
				$parameters[$key] = 0;
			}
		}

		$GLOBALS["beans"]->queryHelper->executeWriteQuery($this->db, $sql, $parameters);
	}

	public function deleteSchedule($scheduleID, $userID) {
		$sql = "DELETE
				FROM Schedule
				WHERE Schedule.ID = :schedule_id
					AND Schedule.User_ID = :user_id";

		$parameters = array(
				":schedule_id" => $scheduleID,
				":user_id" => $userID
		);

		$GLOBALS["beans"]->queryHelper->executeWriteQuery($this->db, $sql, $parameters);
	}

	public function getCurrentSchedule($userID, $currentDayNumber, $currentTime)
	{
		$days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

		$sql = "SELECT Schedule.*,
					TIME_FORMAT(Schedule.Start_Time, '%h:%i %p') AS Start_Time_12,
					TIME_FORMAT(Schedule.End_Time, '%h:%i %p') AS End_Time_12,
					TIME_FORMAT(Schedule.Start_Time, '%H:%i') AS Start_Time_24,
					TIME_FORMAT(Schedule.End_Time, '%H:%i') AS End_Time_24,
					CASE";

		for ($i = $currentDayNumber; $i < ($currentDayNumber + 7); $i++) {
			$day = $days[($i % 7)];
			$sql .= " WHEN " . $day . " = 1 THEN '" . $day . "'";
		}

		$sql .= " END AS Display_Day
				FROM Schedule
				WHERE Schedule.User_ID = :user_id
				ORDER BY CASE
					WHEN " . $days[$currentDayNumber] . " = 1 AND Start_Time <= :current_time AND End_Time > :current_time THEN 1
			        WHEN " . $days[$currentDayNumber] . " = 1 AND Start_Time > :current_time THEN 2";

		$orderNumber = 3;
		for ($i = ($currentDayNumber + 1); $i < ($currentDayNumber + 8); $i++) {
			$day = $days[($i % 7)];
			$sql .= " WHEN " . $day . " = 1 THEN " . $orderNumber;
			$orderNumber++;
		}

		$sql .= " END,
			    Start_Time,
			    End_Time
			LIMIT 1";

		$parameters = array(
				":user_id" => $userID,
				":current_time" => $currentTime
		);

		return $GLOBALS["beans"]->queryHelper->getSingleRowObject($this->db, $sql, $parameters);
	}

}
