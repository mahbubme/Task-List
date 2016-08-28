<?php $pageTitle = "Register Page"; ?>

<?php include_once 'partials/header.php'; ?>
<?php include_once 'partials/parseSignup.php'; ?>

	<div class="container">
		<div class="row">
			<?php if ( !isset( $_SESSION['username'] ) ) : ?>
				<div class="col .col-xs-12 .col-sm-3 .col-md-3 col-lg-3"></div>
			    <div class="col .col-xs-12 .col-sm-6 .col-md-6 col-lg-6 main white">
			        <h3 class="text-primary">Registration </h3><hr>
					
					<?php if ( isset( $result ) ) echo $result; ?>
					<?php if( !empty( $form_errors ) ) echo show_errors( $form_errors ); ?>

					<form method="post" action="">
						<div class="form-group">
							<input type="email" class="form-control" id="email" name="email" placeholder="Email">
						</div>
						<div class="form-group">
							<input type="text" class="form-control" id="username" name="username" placeholder="Username">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" id="password" name="password" placeholder="Password">
						</div>
						<div class="form-group clearfix">
							<p class="pull-left page-link">Already have an account? <a href="login.php">Login</a></p>
							<input type="hidden" name="token" value="<?php if ( function_exists( '_token' ) ) echo _token(); ?>">
							<button type="submit" class="btn btn-default pull-right" name="signupBtn">Sign up</button>
						</div>
					</form>

			    </div>
			    <div class="col .col-xs-12 .col-sm-3 .col-md-3 col-lg-3"></div>
			<?php else: ?>
				<?php redirectTo( 'index' ); ?>
			<?php endif; ?>  
	    </div>
	</div>

<?php include_once 'partials/footer.php'; ?>