<?php

class Feels
{

	public function index()
	{
		$userID = $GLOBALS["beans"]->siteHelper->getSession("userID");

		$feels = $GLOBALS["beans"]->feelService->getFeels($userID);

		require APP . 'views/_templates/header.php';
		require APP . 'views/feels/index.php';
		require APP . 'views/_templates/footer.php';
	}

	public function edit($feelID = "")
	{
		$userID = $GLOBALS["beans"]->siteHelper->getSession("userID");
		$feel = $GLOBALS["beans"]->feelService->getFeel($feelID, $userID);

		require APP . 'views/_templates/header.php';
		require APP . 'views/feels/edit.php';
		require APP . 'views/_templates/footer.php';
	}

	public function save()
	{
		$GLOBALS["beans"]->feelService->saveFeel();

		header('location: ' . URL_WITH_INDEX_FILE . 'feels');
	}

	public function delete($feelID)
	{
		$userID = $GLOBALS["beans"]->siteHelper->getSession("userID");
		$GLOBALS["beans"]->feelService->deleteFeel($feelID, $userID);

		header('location: ' . URL_WITH_INDEX_FILE . 'feels');
	}

}
