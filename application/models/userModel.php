<?php

class UserModel extends Model
{

	public function getUser($userID)
	{
		$sql = "SELECT User.*
				FROM User
				WHERE User.ID = :user_id";

		$parameters = array(":user_id" => $userID);

		return $GLOBALS["beans"]->queryHelper->getSingleRowObject($this->db, $sql, $parameters);
	}

	public function insertUser() {
		$sql = "INSERT INTO User (First_Name, Last_Name, Email, Password, Created_On, Modified_On)
				VALUES (:first_name, :last_name, :email, :password, NOW(), NOW())";

		$parameters = array(
				":first_name" => $_POST["firstName"],
				":last_name" => $_POST["lastName"],
				":email" => $_POST["email"],
				":password" => password_hash($_POST["password"],PASSWORD_DEFAULT)
			);

		return $GLOBALS["beans"]->queryHelper->executeWriteQuery($this->db, $sql, $parameters);
	}

	public function updateUser() {
		$sql = "UPDATE User
				SET First_Name = :first_name,
					Last_Name = :last_name,
					Email = :email,";
		if ($_POST["password"] != "") {
			$sql .= "Password = :password,";
		}
		$sql .= "Temperature_Unit = :temperature_unit,
				Time_Format = :time_format,
				Home_Screen = :home_screen,
				Modified_On = NOW()
				WHERE User.ID = :user_id";
	
		$parameters = array(
				":user_id" => $_POST["userID"],
				":first_name" => $_POST["firstName"],
				":last_name" => $_POST["lastName"],
				":email" => $_POST["email"],
				":temperature_unit" => $_POST["temperatureUnit"],
				":time_format" => $_POST["timeFormat"],
				":home_screen" => $_POST["homeScreen"]
		);
		if ($_POST["password"] != "") {
			$parameters["password"] = password_hash($_POST["password"],PASSWORD_DEFAULT);
		}
	
		$GLOBALS["beans"]->queryHelper->executeWriteQuery($this->db, $sql, $parameters);
	}

	public function getLoginInfo($email)
	{
		$sql = "SELECT ID, Email, Password, Temperature_Unit, Time_Format, Home_Screen
				FROM User
				WHERE Email = :email";

		$parameters = array(":email" => $email);

		return $GLOBALS["beans"]->queryHelper->getSingleRowObject($this->db, $sql, $parameters);
	}

}
