<?php 
	
	if ( isset( $_POST['passwordResetBtn'], $_POST['token'] ) ) {

		if ( validate_token( $_POST['token'] ) ) {
			
			$form_errors = array();

			$required_fields = array( 'new_password', 'confirm_password' );

			$form_errors = array_merge( $form_errors, check_empty_fields( $required_fields ) );

			$fields_to_check_length = array( 'new_password' => 6, 'confirm_password' => 6 );

			$form_errors = array_merge( $form_errors, check_min_length( $fields_to_check_length ) );
			
			if ( empty( $form_errors ) ) {

				//collect form data and store in variables
				$id = $_POST['user_id'];
				$password1 = $_POST['new_password'];
				$password2 = $_POST['confirm_password'];

				if ( $password1 != $password2 ) {

					$result = flashMessage( "New password and confirm password does not match" );

				}else {

					try{

						$sqlQuery = "SELECT id FROM users WHERE id =:id";

						$statement = $conn->prepare( $sqlQuery );
						$statement->execute( array( ':id' => $id ) );

						if ( $statement->rowCount() == 1 ) {

							$hashed_password = password_hash( $password1, PASSWORD_DEFAULT );

							$sqlUpdate = "UPDATE users SET password = :password WHERE id = :id";

							$statement = $conn->prepare( $sqlUpdate );
							$statement->execute( array( ':password' => $hashed_password, ':id' => $id ) );

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

		}else {

			// throw an error
			$result = "<script type='text/javascript'>
						swal('Error', 'This request originates from an unknown source, possible attack', 'error');
					   </script>";				
		}

	}else if ( isset( $_POST['passwordRecoveryBtn'], $_POST['token'] ) ) {

		if ( validate_token( $_POST['token'] ) ) {

			$form_errors = array();
			$required_fields = array( 'email' );
			$form_errors = array_merge( $form_errors, check_empty_fields( $required_fields ) );
			$form_errors = array_merge( $form_errors, check_email( $_POST ) );

			if ( empty( $form_errors ) ) {

				$email = $_POST['email'];

					try {
						
						$sqlQuery = "SELECT * FROM users WHERE email = :email";
						$statement = $conn->prepare( $sqlQuery );
						$statement->execute( array( ':email' => $email ) );

						if ( $rs = $statement->fetch() ) {

							$username = $rs['username'];
							$email = $rs['email'];
							$user_id = $rs['id'];
							$encode_id = base64_encode( "encodeuserid{$user_id}" );

							// prepare email body
							$to = $email;
							$admin_email = "mail@example.com";
							$subject = "Password Recovery Message from Task List";

							// prepare email body
							$mail_body = '<html>
								              <body>
								                  <h2>Task List: Code A Secured Login System</h2>
								                  <p>Dear '.$username.' <br><br> to reset your login password, please click on the link below.</p>
								                  <p><a href="http://localhost/Task-List/src/forgot_password.php?id='.$encode_id.'">Reset Password</a></p>
								                  <p><strong>&copy;2016 Task List</strong></p>
								              </body>
										  </html>';

							$headers  = "MIME-VERSION: 1.0" . "\r\n";
							$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
							$headers .= "From: <$admin_email>" . "\r\n"; 

							// error handling for mail
							if ( mail( $to, $subject, $mail_body, $headers ) ) {
								
								$result = "<script type=\"text/javascript\">
											swal({
												title: \"Password Recovery\",
												text: \"Password reset link sent successfully, please check your email address.\",
												type: 'success',
												confirmButtonText: \"Thank You!\"
											});
										   </script>";

							}
							else {

								$result = "<script type=\"text/javascript\">
											swal(\"Error\",\"Email sending failed\", \"error\");
										   </script>";
								
							}
						}
						else {

							$result = "<script type=\"text/javascript\">
											swal({
												title: \"OOPS!!\",
												text: \"The email address provided does not exist in our database, please try again.\",
												type: 'error',
												confirmButtonText: \"Ok!\"
											});
										   </script>";

						}

					} catch (PDOException $ex) {

						$result =	flashMessage( "An error occurred: " .$ex->getMessage() );

					}

			}
			else {

				if ( count( $form_errors ) == 1 ) {

					$result = flashMessage( "There was 1 error in the form" );

				}else{
					
					$result = flashMessage( "There were " .count( $form_errors ). " errors in the form" );

				}

			}

		}else {

			// throw an error
			$result = "<script type='text/javascript'>
						swal('Error', 'This request originates from an unknown source, possible attack', 'error');
					   </script>";	

		}

	}

?>