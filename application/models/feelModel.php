<?php

class FeelModel extends Model
{

	public function getFeels($userID)
	{
		$sql = "SELECT Feel.*
				FROM Feel
				WHERE Feel.User_ID = :user_id
				ORDER BY Feel.Min_Temperature_F, Feel.Max_Temperature_F";

		$parameters = array(":user_id" => $userID);

		$query = $this->db->prepare($sql);
		$query->execute($parameters);

		return $query->fetchAll();
	}

	public function getFeel($feelID, $userID = "")
	{
		$sql = "SELECT Feel.*
				FROM Feel
				WHERE Feel.ID = :feel_id";
		if (is_numeric($userID)) {
			$sql .= " AND Feel.User_ID = :user_id";
		}

		$parameters = array(':feel_id' => $feelID);
		if (is_numeric($userID)) {
			$parameters[":user_id"] = $userID;
		}

		return $GLOBALS["beans"]->queryHelper->getSingleRowObject($this->db, $sql, $parameters);
	}

	public function insertFeel() {
		$sql = "INSERT INTO Feel (User_ID, Min_Temperature_C, Max_Temperature_C, Min_Temperature_F, Max_Temperature_F, Description, Bring_Wear, Created_On, Modified_On)
				VALUES (:user_id, :min_temperature_c, :max_temperature_c, :min_temperature_f, :max_temperature_f, :description, :bring_wear, NOW(), NOW())";

		$parameters = array(
				":user_id" => $_POST["userID"],
				":description" => $_POST["description"],
				":bring_wear" => $_POST["bringWear"]
		);
		
		if (strcasecmp($GLOBALS["beans"]->siteHelper->getSession("temperatureUnit"), "C") == 0) {
			$parameters[":min_temperature_c"]= $_POST["minTemperature"];
			$parameters[":max_temperature_c"] = $_POST["maxTemperature"];
			$parameters[":min_temperature_f"] = $GLOBALS["beans"]->mathHelper->convertCelsiusToFahrenheit($_POST["minTemperature"]);
			$parameters[":max_temperature_f"] = $GLOBALS["beans"]->mathHelper->convertCelsiusToFahrenheit($_POST["maxTemperature"]);
		}
		else {
			$parameters[":min_temperature_f"]= $_POST["minTemperature"];
			$parameters[":max_temperature_f"] = $_POST["maxTemperature"];
			$parameters[":min_temperature_c"] = $GLOBALS["beans"]->mathHelper->convertFahrenheitToCelsius($_POST["minTemperature"]);
			$parameters[":max_temperature_c"] = $GLOBALS["beans"]->mathHelper->convertFahrenheitToCelsius($_POST["maxTemperature"]);
		}

		return $GLOBALS["beans"]->queryHelper->executeWriteQuery($this->db, $sql, $parameters);
	}

	public function updateFeel() {
		$sql = "UPDATE Feel
				SET Min_Temperature_C = :min_temperature_c,
					Max_Temperature_C = :max_temperature_c,
					Min_Temperature_F = :min_temperature_f,
					Max_Temperature_F = :max_temperature_f,
					Description = :description,
					Bring_Wear = :bring_wear,
					Modified_On = NOW()
				WHERE Feel.ID = :feel_id
					AND Feel.User_ID = :user_id";

		$parameters = array(
				":feel_id" => $_POST["feelID"],
				":user_id" => $_POST["userID"],
				":description" => $_POST["description"],
				":bring_wear" => $_POST["bringWear"]
		);

		if (strcasecmp($GLOBALS["beans"]->siteHelper->getSession("temperatureUnit"), "C") == 0) {
			$parameters[":min_temperature_c"]= $_POST["minTemperature"];
			$parameters[":max_temperature_c"] = $_POST["maxTemperature"];
			$parameters[":min_temperature_f"] = $GLOBALS["beans"]->mathHelper->convertCelsiusToFahrenheit($_POST["minTemperature"]);
			$parameters[":max_temperature_f"] = $GLOBALS["beans"]->mathHelper->convertCelsiusToFahrenheit($_POST["maxTemperature"]);
		}
		else {
			$parameters[":min_temperature_f"]= $_POST["minTemperature"];
			$parameters[":max_temperature_f"] = $_POST["maxTemperature"];
			$parameters[":min_temperature_c"] = $GLOBALS["beans"]->mathHelper->convertFahrenheitToCelsius($_POST["minTemperature"]);
			$parameters[":max_temperature_c"] = $GLOBALS["beans"]->mathHelper->convertFahrenheitToCelsius($_POST["maxTemperature"]);
		}

		$GLOBALS["beans"]->queryHelper->executeWriteQuery($this->db, $sql, $parameters);
	}

	public function deleteFeel($feelID, $userID) {
		$sql = "DELETE
				FROM Feel
				WHERE Feel.ID = :feel_id
					AND Feel.User_ID = :user_id";

		$parameters = array(
				":feel_id" => $feelID,
				":user_id" => $userID
		);

		$GLOBALS["beans"]->queryHelper->executeWriteQuery($this->db, $sql, $parameters);
	}

	public function getFeelsByTemperature($temperature)
	{
		$sql = "SELECT Feel.*
				FROM Feel
				WHERE Feel.User_ID = :user_id";

		if (strcasecmp($GLOBALS["beans"]->siteHelper->getSession("temperatureUnit"), "C") == 0) {
			$sql .= " AND Feel.Min_Temperature_C <= :temperature
						AND Feel.Max_Temperature_C >= :temperature
					ORDER BY Feel.Min_Temperature_C, Feel.Max_Temperature_C";
		}
		else {
			$sql .= " AND Feel.Min_Temperature_F <= :temperature
						AND Feel.Max_Temperature_F >= :temperature
					ORDER BY Feel.Min_Temperature_F, Feel.Max_Temperature_F";
		}

		$parameters = array(
			':user_id' => $GLOBALS["beans"]->siteHelper->getSession("userID"),
			':temperature' => $temperature
		);

		$query = $this->db->prepare($sql);
		$query->execute($parameters);

		return $query->fetchAll();
	}

}
