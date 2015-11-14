<?php

class UserService extends Service
{

	public function getUser($userID)
	{
		return $this->model->getUser($userID);
	}

	public function getLoginInfo($email)
	{
		return $this->model->getLoginInfo($email);
	}

	public function insertUser()
	{
		$this->model->insertUser();
	}

	public function updateUser()
	{
		$this->model->updateUser();

		$_SESSION["temperatureUnit"] = $_POST["temperatureUnit"];
		$_SESSION["timeFormat"] = $_POST["timeFormat"];
		$_SESSION["homeScreen"] = $_POST["homeScreen"];
	}

	public function login()
	{
		$errorMessage = "Invalid email or password.";
		$loginInfo = $this->model->getLoginInfo($_POST["loginEmail"]);

		if (strcasecmp($_POST["loginEmail"],$loginInfo->Email) == 0)
		{
			if (password_verify($_POST["loginPassword"],$loginInfo->Password))
			{
				$_SESSION["userID"] = $loginInfo->ID;
				$_SESSION["temperatureUnit"] = $loginInfo->Temperature_Unit;
				$_SESSION["timeFormat"] = $loginInfo->Time_Format;
				$_SESSION["homeScreen"] = $loginInfo->Home_Screen;
				$errorMessage = "";
			}
		}

		return $errorMessage;
	}

	public function logout()
	{
		// Unset all of the session variables.
		$_SESSION = array();
		
		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
			);
		}
		
		// Finally, destroy the session.
		session_destroy();
	}

}