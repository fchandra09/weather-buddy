<?php

class Schedule
{

	public function index()
	{
		$userID = $GLOBALS["beans"]->siteHelper->getSession("userID");

		$scheduleList = $GLOBALS["beans"]->scheduleService->getScheduleList($userID);

		require APP . 'views/_templates/header.php';
		require APP . 'views/schedule/index.php';
		require APP . 'views/_templates/footer.php';
	}

	public function edit($scheduleID = "")
	{
		$userID = $GLOBALS["beans"]->siteHelper->getSession("userID");
		$schedule = $GLOBALS["beans"]->scheduleService->getSchedule($scheduleID, $userID);

		require APP . 'views/_templates/header.php';
		require APP . 'views/schedule/edit.php';
		require APP . 'views/_templates/footer.php';
	}

	public function save()
	{
		$GLOBALS["beans"]->scheduleService->saveSchedule();

		header('location: ' . URL_WITH_INDEX_FILE . 'schedule');
	}

	public function delete($scheduleID)
	{
		$userID = $GLOBALS["beans"]->siteHelper->getSession("userID");
		$GLOBALS["beans"]->scheduleService->deleteSchedule($scheduleID, $userID);

		header('location: ' . URL_WITH_INDEX_FILE . 'schedule');
	}

}
