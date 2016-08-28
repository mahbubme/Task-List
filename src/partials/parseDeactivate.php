<?php 
	
	if ( isset( $_POST['deleteAccountBtn'], $_POST['token'] ) ) {
		
		if ( validate_token( $_POST['token'] ) ) {

			$id = $_POST['hidden_id'];

			
			try {

				//STEP 1: Retrieve user information from the database
				$sqlQuery = "SELECT * FROM users WHERE id = :id";
				$statement = $conn->prepare($sqlQuery);
				$statement->execute( array( ':id' => $id ) );

				if ( $row = $statement->fetch() ) {
					
					//STEP 2: Deactivate the account
					$username = $row['username'];
					$email = $row['email'];
					$user_id = $row['id'];

					$deactivateQuery = "UPDATE users SET activated = :activated WHERE id = :id";
					$statement = $conn->prepare($deactivateQuery);
					$statement->execute( array( ':activated' => 0, ':id' => $user_id ) );

					if ( $statement->rowCount() === 1 ) {
						
						//STEP 3: Insert record into the trash table
						$insertQuery = "INSERT INTO trash(user_id, deleted_at) VALUES(:id, now())";
						$statement = $conn->prepare($insertQuery);
						$statement->execute( array( ':id' => $user_id ) );

						if ( $statement->rowCount() === 1 ) {
							
							//STEP 4: Notification the user via email and display confirmation alert
							$to = $email;
							$admin_email = "mail@example.com";
							$subject = "Task List: Account Deactivated";

							// prepare email body
							$mail_body = '<html>
								              <body>
								                  <h2>Task List: Code A Secured Login System</h2>
								                  <p>Dear '.$username.' <br><br> You have requested to deactivate your account, your account information will be kept for 14 days, if you wish to continue using this system login within the next 14 days to reacitvate your account or it will be permanently deleted.</p>
								                  <p><a href="http://localhost/Task-List/src/login.php">Sign In</a></p>
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
												title: \"Dear $username\",
												text: \"Your account information will be kept for 14 days, if you wish to continue using this system login within the next 14 days or it will be permanently deleted.\",
												type: 'success',
												confirmButtonText: \"Thank You!\"
											});

											setTimeout(function(){
												window.location.href = 'logout.php';
											}, 5000);
										   </script>";

							}
							else {

								$result = "<script type=\"text/javascript\">
											swal(\"Error\",\"Email sending failed\", \"error\");
										   </script>";
								
							}

						}
						else {

							$result = flashMessage( "Couldn't complete the operation please try again" );
							
						}

					}
					else{

						$result = flashMessage( "Couldn't complete the operation please try again" );
					}

				}
				else {

					signout();

				}
								
			} catch ( PDOException $ex)  {

				$result = flashMessage("An error occurred" .$ex->getMessage() );
				
			}

		}
		else {

			$result = "<script type='text/javascript'>
						swal('Error','This request originates from an unknown source, possible attack', 'error');
					   </script>";

		}

	}

?>