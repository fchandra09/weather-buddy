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

		header('location: ' . URL_WITH_INDEX_FILE);
	}

	public function logout()
	{
		$GLOBALS["beans"]->userService->logout();

		header('location: ' . URL_WITH_INDEX_FILE);
	}

	public function createAccount()
	{
		$GLOBALS["beans"]->userService->insertUser();
		$this->login();
	}

	public function checkUniqueEmail()
	{
		$unique = false;
		$loginInfo = $GLOBALS["beans"]->userService->getLoginInfo($_POST["email"]);

		if (!is_numeric($loginInfo->ID))
		{
			$unique = true;
		}

		var_export($unique);
	}

	public function save()
	{
		$GLOBALS["beans"]->userService->updateUser();
	
		header('location: ' . URL_WITH_INDEX_FILE . 'user');
	}
}
