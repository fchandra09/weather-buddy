<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); }

$firstName = "";
$lastName = "";
$email = "";
?>

<script>
	$(document).ready(function(){
		$('#login-form').validate({
			rules: {
				loginEmail: {
					email: true
				}
			}
		});

		$('#create-form').validate({});

		$('#create-div').hide();

		$('#login-tab,#create-tab').click(toggleTab);
	});

	toggleTab = function() {
		if ($(this).attr('id') == 'create-tab') {
			$('#login-tab').closest('td').removeClass('active');
			$('#create-tab').closest('td').addClass('active');
			$('#login-div').hide();
			$('#create-div').show();
		}
		else {
			$('#create-tab').closest('td').removeClass('active');
			$('#login-tab').closest('td').addClass('active');
			$('#create-div').hide();
			$('#login-div').show();
		}
	}
</script>

<div class="container login-container">

	<?php echo $GLOBALS["beans"]->siteHelper->getAlertHTML(); ?>

	<h2 class="page-header">Welcome to My Weather Buddy!</h2>

	<div class="col-sm-6 login-box">
		<table class="table-panel">
			<tr class="table-panel-tabs">
				<td class="table-panel-tab active">
					<span id="login-tab">Login</span>
				</td>
				<td class="table-panel-tab create">
					<span id="create-tab">Create Account</span>
				</td>
				<td></td>
			</tr>
			<tr class="table-panel-content">
				<td colspan="3">
					<div id="login-div">
						<form id="login-form" method="post" action="<?php echo URL_WITH_INDEX_FILE; ?>user/login" class="form-horizontal">
							<div class="form-group">
								<label for="loginEmail" class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10 form-field">
									<input type="email" id="loginEemail" name="loginEmail" class="form-control" required aria-required="true" />
								</div>
							</div>
							<div class="form-group">
								<label for="loginPassword" class="col-sm-2 control-label">Password</label>
								<div class="col-sm-10 form-field">
									<input type="password" id="loginPassword" name="loginPassword" class="form-control" required aria-required="true" />
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10 form-button">
									<button type="submit" class="btn btn-default">Login</button>
								</div>
							</div>
						</form>
					</div>

					<div id="create-div">
						<form id="create-form" method="post" action="<?php echo URL_WITH_INDEX_FILE; ?>user/createAccount" class="form-horizontal">
							<?php require 'user/_editLogin.php' ?>
							<div class="form-group">
								<div class="col-sm-offset-2 col-sm-10 form-button">
									<button type="submit" class="btn btn-default">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</td>
			</tr>
		</table>
	</div>

	<div class="col-sm-6 introduction-box">
		Do you always bring an umbrella when it does not rain?
		And forget to bring one when it rains?
		Do you have any trouble interpreting different temperatures?
		If so, simply create an account and login to access your very own personalized weather data!
	</div>
</div>