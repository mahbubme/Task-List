<?php $pageTitle = "Login Page"; ?>

<?php include_once 'partials/header.php'; ?>

<?php 
	
	if ( isset( $_POST['loginBtn'] ) ) {

		// array to hold errors
		$form_errors = array();

		//validate
		$required_fields = array( 'username', 'password' );

		$form_errors = array_merge( $form_errors, check_empty_fields( $required_fields ) );

		if ( empty( $form_errors ) ) {

			// collect form data
			$user = $_POST['username'];
			$password = $_POST['password'];


			// check if user exist in the database
			$sqlQuery = "SELECT * FROM users WHERE username = :username";
			$statement = $conn->prepare( $sqlQuery );
			$statement->execute( array( ":username" => $user ) );

			while ( $row = $statement->fetch() ) {

				$id = $row['id'];
				$hashed_password = $row['password'];
				$username = $row['username'];

				if ( password_verify( $password, $hashed_password ) ) {

					$_SESSION['id'] = $id;
					$_SESSION['username'] = $username;

					// call sweet alert
					echo $welcome = "<script type=\"text/javascript\">
									swal({   
										title: \"Welcome back $username!\",   
										text: \"You're being logged in.\",   
										type: 'success',
										timer: 3000,   
										showConfirmButton: false 
									});

									setTimeout( function() {
										window.location.href = 'index.php';
									}, 2000);
								</script>";

					//redirectTo( 'index' );

				}else {

					$result = flashMessage( "Invalid username or password" );

				}

			}


		}else {

			if ( count( $form_errors ) == 1 ) {

				$result = flashMessage( "There was one error in the form" );

			}else {

				$result = flashMessage( "There were " .count( $form_errors ). " error in the form" );

			}

		}

	}

?>

	<div class="container">
		<div class="row">
			<div class="col .col-xs-12 .col-sm-3 .col-md-3 col-lg-3"></div>
		    <div class="col .col-xs-12 .col-sm-6 .col-md-6 col-lg-6 main white">
		        <h3 class="text-primary">Login </h3><hr>
				
				<?php if ( isset( $result ) ) echo $result; ?>
				<?php if ( !empty( $form_errors ) ) echo show_errors( $form_errors ); ?> 
				<form method="post" action="">
					<div class="form-group">
						<input type="text" class="form-control" id="username" name="username" placeholder="Username">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="password" name="password" placeholder="Password">
					</div>
					<div class="form-group checkbox">
						<label>
					      <input type="checkbox" name="remember"> Remember Me
					    </label>
					</div>
					<div class="form-group clearfix">
						<p class="pull-left page-link"><a href="forgot_password.php">Forgot Password?</a> | <a href="signup.php"> Register </a></p>
						<button type="submit" class="btn btn-default pull-right" name="loginBtn">Login</button>
					</div>
				</form>
		    </div>
		    <div class="col .col-xs-12 .col-sm-3 .col-md-3 col-lg-3"></div>
	    </div>
	</div>

<?php include_once 'partials/footer.php'; ?>