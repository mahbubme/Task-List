<?php $pageTitle = "Password Reset Page"; ?>

<?php include_once 'partials/header.php'; ?>
<?php include_once 'partials/parseForgotPassword.php'; ?>

	<div class="container">
		<div class="row">
			<div class="col .col-xs-12 .col-sm-3 .col-md-3 col-lg-3"></div>
		    <div class="col .col-xs-12 .col-sm-6 .col-md-6 col-lg-6 main white">
		        <h3 class="text-primary">Password Reset Form </h3><hr>
				
				<?php if( isset( $result ) ) echo $result; ?>
				<?php if( !empty( $form_errors )) echo show_errors( $form_errors ); ?>
				<form method="post" action="">
					<div class="form-group">
						<input type="email" class="form-control" id="email" name="email" placeholder="Email">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
					</div>
					<div class="form-group clearfix">
						<p class="pull-left page-link"><a href="login.php">Login</a></p>
						<button type="submit" class="btn btn-default pull-right" name="passwordResetBtn">Reset Password</button>	
					</div>
				</form>
		    </div>
		    <div class="col .col-xs-12 .col-sm-3 .col-md-3 col-lg-3"></div>
	    </div>
	</div>

<?php include_once 'partials/footer.php'; ?>