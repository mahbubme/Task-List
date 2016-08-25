<?php 
	
	// process the form
	if ( isset( $_POST['signupBtn'], $_POST['token'] ) ) {

		if ( validate_token( $_POST['token'] ) ) {
			// initialize an array to store any error message from the form
			$form_errors = array();

			// form validation
			$required_fields = array( 'email', 'username', 'password' );

			// call the function to check empty field and merge the return data into form_error array
			$form_errors = array_merge( $form_errors, check_empty_fields( $required_fields ) );

			// fields that requires checking for minimum length
			$fields_to_check_length = array( 'username' => 4, 'password' => 6 );

			// call the function to check minimum required length and merge the return data ino form_error array
			$form_errors = array_merge( $form_errors, check_min_length( $fields_to_check_length ) );

			// email validation / merge the return data into form_error array
			$form_errors = array_merge( $form_errors, check_email( $_POST ) );

			// collect form data and store in variables
			$email = $_POST['email'];
			$username = $_POST['username'];
			$password = $_POST['password'];

			if ( checkDuplicateEntries( "users", "email", $email, $conn ) ) {

				$result = flashMessage( "Email is already taken, please try another one" );

			}
			else if ( checkDuplicateEntries( "users", "username", $username, $conn ) ) {

				$result = flashMessage( "Username is already taken, please try another one" );

			}

			//check if error array is empty, if yes process form data and insert record
			else if ( empty( $form_errors ) ) {

				// password hashing
				$hashed_password = password_hash( $password, PASSWORD_DEFAULT );

				try{

					$sqlInsert = "INSERT INTO users (username, email, password, join_date) 
								VALUES (:username, :email, :password, now() )";

					$statement = $conn->prepare( $sqlInsert );
					$statement->execute( array( ':username' => $username, ':email' => $email, ':password' => $hashed_password ) );

					if ( $statement->rowCount() == 1 ) {

						// get the last inserted id
						$user_id = $conn->lastInsertId();

						//encode the id
						$encode_id = base64_encode( "encodeuserid{$user_id}" );

						$to = $email;
						$admin_email = "mail@example.com";
						$subject = "Verify your email address";

						// prepare email body
						$mail_body = '<html>
							              <body>
							                  <h2>Task List: Code A Secured Login System</h2>
							                  <p>Dear '.$username.' <br><br> Thank you for registering, please click on the link below to confirm your email address</p>
							                  <p><a href="http://localhost/Task-List/src/activate.php?id='.$encode_id.'">Confirm Email</a></p>
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
											title: \"Congratulations $username\",
											text: \"Registration Completed Successfully. Please check your email for confirmation link\",
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

				}catch ( PDOException $ex ) {

					$result = flashMessage( "An error occurred: " .$ex->getMessage() );

				}

			}
			else{

				if ( count( $form_errors ) == 1 ) {

					$result  = flashMessage( "There was 1 error in the form", "Pass" );

				}else {

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
	// account verification
	else if ( isset( $_GET['id'] ) ) {

		$encode_id = $_GET['id'];
		$decode_id = base64_decode( $encode_id );
		$user_id_array = explode( "encodeuserid", $decode_id );
		$id = $user_id_array[1];

		$sql = "UPDATE users SET activated =:activated WHERE id=:id AND activated='0'";

		$statement = $conn->prepare( $sql );
		$statement->execute( array( ':activated' => "1", ':id' => $id ) );

		if ( $statement->rowCount() == 1 ) {

			$result = '<h2>Email Confirmed</h2>
					   <p>Your email address has been verified, you can now <a href="login.php">login</a> with your email and password.</p>
					  ';

		}else {

			$result = "<p class='lead'>No changes made please contact site admin, if you have not confirmed your email before.</p>";
		}

	}	

?>