<?php

class User
{

	public function index()
	{
		require APP . 'views/_templates/header.php';
		if (is_numeric($GLOBALS["beans"]->siteHelper->getSession("userID")))
		{
			$userID = $GLOBALS["beans"]->siteHelper->getSession("userID");
			$user = $GLOBALS["beans"]->userService->getUser($userID);
			require APP . 'views/user/index.php';
		}
		else
		{
			require APP . 'views/index.php';
		}
		require APP . 'views/_templates/footer.php';
	}

	public function edit()
	{
		$userID = $GLOBALS["beans"]->siteHelper->getSession("userID");
		$user = $GLOBALS["beans"]->userService->getUser($userID);

		require APP . 'views/_templates/header.php';
		require APP . 'views/user/edit.php';
		require APP . 'views/_templates/footer.php';
	}

	public function login()
	{
		$errorMessage = $GLOBALS["beans"]->userService->login();

		if ($errorMessage != "")
		{
			$GLOBALS["beans"]->siteHelper->setAlert("danger", $errorMessage);

			header('location: ' . URL_WITH_INDEX_FILE . 'user');
		}
		else
		{
			header('location: ' . URL_WITH_INDEX_FILE);
		}
	}

	public function logout()
	{
		$GLOBALS["beans"]->userService->logout();

		header('location: ' . URL_WITH_INDEX_FILE);
	}

	public function createAccount()
	{
		$userID = $GLOBALS["beans"]->userService->insertUser();
		$GLOBALS["beans"]->feelService->presetDefaultFeels($userID);

		$GLOBALS["beans"]->siteHelper->setAlert("success", "Congratulations, your account has been created. Please use the form below to login.");

		header('location: ' . URL_WITH_INDEX_FILE . 'user');
	}

	public function checkUniqueEmail()
	{
		$unique = false;
		$loginInfo = $GLOBALS["beans"]->userService->getLoginInfo($_POST["email"]);

		if (!is_numeric($loginInfo->ID))
		{
			$unique = true;
		}

		echo json_encode($unique);
	}

	public function save()
	{
		$GLOBALS["beans"]->userService->updateUser();
	
		header('location: ' . URL_WITH_INDEX_FILE . 'user');
	}
}
