<?php 
	
	if ( isset( $_POST['changePasswordBtn'], $_POST['token'] ) ) {

		if ( validate_token( $_POST['token'] ) ) {
			
			$form_errors = array();
			$required_fields = array( 'current_password', 'new_password', 'confirm_password' );
			$form_errors = array_merge( $form_errors, check_empty_fields( $required_fields ) );
			$fields_to_check_length = array( 'new_password' => 6, 'confirm_password' => 6 );
			$form_errors = array_merge( $form_errors, check_min_length( $fields_to_check_length ) );

			if ( empty( $form_errors ) ) {

				$id = $_POST['hidden_id'];
				$current_password = $_POST['current_password'];
				$password1 = $_POST['new_password'];
				$password2 = $_POST['confirm_password'];

				if ( $password1 != $password2 ) {

					$result = flashMessage( "New password and confirm password does not match" );

				}
				else{

					try {

						// check if the old password is correct and process request
						$sqlQuery = "SELECT password FROM users WHERE id = :id";
						$statement = $conn->prepare( $sqlQuery );
						$statement->execute( array( ':id' => $id ) );

						if ( $row = $statement->fetch() ) {

							$password_from_db = $row['password'];

							if ( password_verify( $current_password, $password_from_db ) ) {

								$hashed_password = password_hash( $password1, PASSWORD_DEFAULT );

								$sqlUpdate = "UPDATE users SET password = :password WHERE id = :id";
								$statement = $conn->prepare($sqlUpdate);
								$statement->execute( array( ':password' => $hashed_password, ':id' => $id ) );

								if ( $statement->rowCount() === 1 ) {

									$result = "<script>
												swal({
													title: \"Operation Successful\",
													text: \"Your password was updated successfully. Login with new password again.\",
													type: 'success',
													confirmButtonText: \"Thank You!\"
												});	

												setTimeout(function(){
													window.location.href = 'logout.php';
												}, 3000);
											   </script>";

								}
								else {

									$result = flashMessage( "No changes saved" );
								}

							}
							else {

								$result = "<script>
											swal({
												title : \"OOPS!!\",
												text: \"Old password is not correct, please try again\",
												type: 'error',
												confirmButtonText: \"Ok!\"
											});
										   </script>";
							}

						}
						else {

							signout();

						}

						
					} catch ( PDOException $ex ) {

						$result = flashMessage( "An error occurred: " .$ex->getMessage() );
						
					}
				}

			}
			else {

				if ( count( $form_errors ) == 1 ) {
					
					$result = flashMessage( "There was 1 error in the form");

				}else {
					
					$result = flashMessage( "There were " .count( $form_errors ). " errors in the form" );

				}

			}

		}
		else {

			$result = "<script type='text/javascript'>
						swal('Error', 'This request originates from an unknown source, possible attack', 'error');
					   </script>";
		}

	}

?>