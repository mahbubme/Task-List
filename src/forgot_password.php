<?php $pageTitle = "Password Reset Page"; ?>

<?php include_once 'partials/header.php'; ?>

<?php 
	
	if ( isset( $_POST['passwordResetBtn'] ) ) {

		$form_errors = array();

		$required_fields = array( 'email', 'new_password', 'confirm_password' );

		$form_errors = array_merge( $form_errors, check_empty_fields( $required_fields ) );

		$fields_to_check_length = array( 'new_password' => 6, 'confirm_password' => 6 );

		$form_errors = array_merge( $form_errors, check_min_length( $fields_to_check_length ) );

		$form_errors = array_merge( $form_errors, check_email( $_POST ) );

		
		if ( empty( $form_errors ) ) {

			//collect form data and store in variables
			$email = $_POST['email'];
			$password1 = $_POST['new_password'];
			$password2 = $_POST['confirm_password'];

			if ( $password1 != $password2 ) {

				$result = flashMessage( "New password and confirm password does not match" );

			}else {

				try{

					$sqlQuery = "SELECT email FROM users WHERE email =:email";

					$statement = $conn->prepare( $sqlQuery );
					$statement->execute( array( ':email' => $email ) );

					if ( $statement->rowCount() == 1 ) {

						$hashed_password = password_hash( $password1, PASSWORD_DEFAULT );

						$sqlUpdate = "UPDATE users SET password = :password WHERE email = :email";

						$statement = $conn->prepare( $sqlUpdate );
						$statement->execute( array( ':password' => $hashed_password, ':email' => $email ) );

						$result = "<script type=\"text/javascript\">
									swal({   
										title: \"Updated!\",   
										text: \"Password Reset Successful.\",   
										type: 'success',
										confirmButtonText: \"Thank You!\"
									});
								</script>";

					}
					else{

						$result = "<script type=\"text/javascript\">
									swal({   
										title: \"OOPS!\",   
										text: \"The email address provided does not exist in our address, please try again.\",   
										type: 'error',
										confirmButtonText: \"Try Again!\"
									});
								</script>";

					}

				}catch ( PDOException $ex ) {

					$result = flashMessage( "An error occurred: " .$ex->getMessage() );

				}

			}

		}
		else {

			if ( count( $form_errors ) == 1 ) {

				$result = flashMessage( "There was 1 error in the form" );

			}else{
				
				$result = flashMessage( "There were " .count( $form_errors ). " errors in the form" );

			}

		}

	}

?>

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