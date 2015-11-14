<?php if (!$this) { exit(header('HTTP/1.0 403 Forbidden')); }

$firstName = "";
$lastName = "";
$email = "";
?>

<style>
	#content {
		width: 500px;
	}
	#createAccountDiv {
		display: none;
	}
	.col-sm-3, .col-sm-4 {
		padding-right: 0;
	}
</style>

<script>
	$(document).ready(function(){
		$('#loginForm').validate({
			rules: {
				loginEmail: {
					email: true
				}
			}
		});

		$('#createAccountForm').validate({});

		$('#loginTab').click(function() {
			$('#createAccountDiv').hide();
			$('#createAccountTab').closest('li').removeClass('active');
			$('#loginDiv').show();
			$('#loginTab').closest('li').addClass('active');
		});

		$('#createAccountTab').click(function() {
			$('#loginDiv').hide();
			$('#loginTab').closest('li').removeClass('active');
			$('#createAccountDiv').show();
			$('#createAccountTab').closest('li').addClass('active');
		});
	});
</script>

<div class="container">
	<div id="content">
		<ul class="nav nav-tabs">
			<li role="presentation" class="active">
				<a id="loginTab" href="#">Login</a>
			</li>
			<li role="presentation">
				<a id="createAccountTab" href="#">Create Account</a>
			</li>
		</ul>

		<div id="loginDiv">
			<form id="loginForm" method="post" action="<?php echo URL_WITH_INDEX_FILE; ?>user/login" class="form-horizontal">
				<div class="form-group">
					<label for="loginEmail" class="col-sm-3 control-label">Email</label>
					<div class="col-sm-9">
						<input type="email" id="loginEemail" name="loginEmail" class="form-control" required aria-required="true" />
					</div>
				</div>
				<div class="form-group">
					<label for="loginPassword" class="col-sm-3 control-label">Password</label>
					<div class="col-sm-9">
						<input type="password" id="loginPassword" name="loginPassword" class="form-control" required aria-required="true" />
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-3 col-sm-9">
						<button type="submit" class="btn btn-default">Login</button>
					</div>
				</div>
			</form>
		</div>

		<div id="createAccountDiv">
			<form id="createAccountForm" method="post" action="<?php echo URL_WITH_INDEX_FILE; ?>user/createAccount" class="form-horizontal">
				<?php require 'user\_editLogin.php' ?>
				<div class="form-group">
					<div class="col-sm-offset-4 col-sm-8">
						<button type="submit" class="btn btn-default">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>