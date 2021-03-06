<?php

// This here blocks direct access to this file (so an attacker can't look into application/views/_templates/header.php).
// "$this" only exists if header.php is loaded from within the app, but not if THIS file here is called directly.
// If someone called header.php directly we completely stop everything via exit() and send a 403 server status code.
// Also make sure there are NO spaces etc. before "<!DOCTYPE" as this might break page rendering.
if (!$this) {
	exit(header('HTTP/1.0 403 Forbidden'));
}

if (!isset($userID)) {
	$userID = $GLOBALS["beans"]->siteHelper->getSession("userID");
}
if (!isset($user)) {
	$user = $GLOBALS["beans"]->userService->getUser($userID);
}

$activeView = "";
if (array_key_exists("PATH_INFO", $_SERVER)) {
	$pathInfoArray = explode("/", $_SERVER["PATH_INFO"]);
	$activeView = $pathInfoArray[1];
}

$settingsNav = false;
if (is_numeric($userID) && in_array(strtolower($activeView), explode(",", "user,feels,schedule"))) {
	$settingsNav = true;
}

$locationSearch = true;
if ($settingsNav || strcasecmp($activeView, "user") == 0) {
	$locationSearch = false;
}
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>My Weather Buddy</title>
	<meta name="description" content="">

	<!-- CSS -->
	<link href="https://fonts.googleapis.com/css?family=Delius" rel="stylesheet" type="text/css">
	<link href="<?php echo URL; ?>public/css/bootstrap.css" rel="stylesheet">
	<link href="<?php echo URL; ?>public/css/bootstrap-theme.css" rel="stylesheet">
	<link href="<?php echo URL; ?>public/css/bootstrap-datepicker3.css" rel="stylesheet">
	<link href="<?php echo URL; ?>public/css/bootstrap-timepicker.css" rel="stylesheet">
	<link href="<?php echo URL; ?>public/css/weather-buddy.css" rel="stylesheet">

	<!-- JS -->
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
	<script src="<?php echo URL; ?>public/js/jquery.validate.js" type="text/javascript"></script>
	<script src="<?php echo URL; ?>public/js/additional-methods.js" type="text/javascript"></script>
	<script src="<?php echo URL; ?>public/js/bootstrap.js"></script>
	<script src="<?php echo URL; ?>public/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo URL; ?>public/js/bootstrap-timepicker.js"></script>
	<script src="<?php echo URL; ?>public/js/application.js"></script>
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<script>
		$.validator.setDefaults({
			errorElement: 'span',
			errorClass: 'help-block error-help-block',
			errorPlacement: function (error, element) {
				if (element.parent().parent().hasClass('checkbox')) {
					element.parent().parent().parent().append(error);
				}
				else if (element.parent('.input-group').length || element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
					error.insertAfter(element.parent());
				}
				else {
					error.insertAfter(element);
				}
			},
			highlight: function(element) {
				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			unhighlight: function(element) {
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
			},
			onfocusout: function (element) {
				$(element).valid();
			}
		});

		$(document).ready(function(){
			// Add asterisk to required fields
			$('input,textarea,select').filter('[required]').each(function(index, element) {
				$(element).closest('.form-group').find('label:first').append('<span class="asterisk-required">*</span>');
			});

			// Add asterisk to required groups of checkboxes or radio buttons
			$('.form-group.required').each(function(index, element) {
				$(element).find('label:first').append('<span class="asterisk-required">*</span>');
			});

			$('#tutorial-video').on('hidden.bs.modal', function (e) {
				$('#tutorial-video iframe').attr('src', $('#tutorial-video iframe').attr('src'));
			});
		});
	</script>
</head>
<body>
	<!-- top bar -->
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container" style="position: relative;">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar-mobile" data-toggle="collapse" type="button">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo URL_WITH_INDEX_FILE; ?>">
					My Weather Buddy
				</a>
			</div>

			<?php if ($locationSearch) { ?>
				<div class="navbar-form navbar-left location-search hidden-xs">
					<div class="input-group">
						<input type="text" class="form-control zip-input" placeholder="Search zip" />
						<span class="input-group-addon zip-input-button">
							<span class="glyphicon glyphicon-search"></span>
						</span>
					</div>
				</div>
			<?php } ?>

			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<?php if (is_numeric($userID)) { ?>
						<li class="dropdown">
							<a class="dropdown-toggle" href="#!" aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown">
								<?php echo $user->First_Name . " " . $user->Last_Name ?>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li>
									<a href="<?php echo URL_WITH_INDEX_FILE; ?>user">Settings</a>
								</li>
								<li>
									<a href="<?php echo URL_WITH_INDEX_FILE; ?>user/logout">Logout</a>
								</li>
								<li>
									<a data-toggle="modal" data-target="#tutorial-video" style="cursor:pointer;">Tutorial Video</a>
								</li>
							</ul>
						</li>
					<?php }
					else { ?>
						<li>
							<a href="<?php echo URL_WITH_INDEX_FILE; ?>user">Login</a>
						</li>
					<?php } ?>
				</ul>
			</div>

			<div id="navbar-mobile" class="collapse">
				<ul class="nav navbar-nav">
					<?php if (is_numeric($userID)) { ?>
						<li class="user-name">
							<?php echo $user->First_Name . " " . $user->Last_Name ?>
						</li>
					<?php } ?>
					<?php if ($locationSearch) { ?>
						<li class="location-search-mobile">
							<div class="input-group">
								<input type="text" class="form-control zip-input" placeholder="Search zip" />
								<span class="input-group-addon zip-input-button">
									<span class="glyphicon glyphicon-search"></span>
								</span>
							</div>
						</li>
					<?php } ?>
					<?php if (is_numeric($userID)) { ?>
						<li>
							<a href="<?php echo URL_WITH_INDEX_FILE; ?>home/today">
								Today's Weather
								<span class="glyphicon glyphicon-chevron-right"></span>
							</a>
						</li>
						<li>
							<a href="<?php echo URL_WITH_INDEX_FILE; ?>home/scheduled">
								Personalized Weather
								<span class="glyphicon glyphicon-chevron-right"></span>
							</a>
						</li>
						<li>
							<a href="<?php echo URL_WITH_INDEX_FILE; ?>user">
								Settings
								<span class="glyphicon glyphicon-chevron-right"></span>
							</a>
						</li>
						<li>
							<a href="<?php echo URL_WITH_INDEX_FILE; ?>user/logout">
								Logout
								<span class="glyphicon glyphicon-chevron-right"></span>
							</a>
						</li>
						<li>
							<a data-toggle="modal" data-target="#tutorial-video" style="cursor:pointer;">
								Tutorial Video
								<span class="glyphicon glyphicon-chevron-right"></span>
							</a>
						</li>
					<?php }
					else { ?>
						<li>
							<a href="<?php echo URL_WITH_INDEX_FILE; ?>user">
								Login
								<span class="glyphicon glyphicon-chevron-right"></span>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</nav>

	<div id="tutorial-video" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">My Weather Buddy Tutorial Video</h4>
				</div>
				<div class="modal-body">
					<iframe width="100%" height="315" src="https://www.youtube.com/embed/RmJjr6LJ46A" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>

	<?php if ($settingsNav) {
		require APP . 'views/_templates/settings.php';
	} ?>