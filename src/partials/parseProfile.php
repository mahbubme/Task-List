<?php 

	if ( ( isset( $_SESSION['id'] ) || isset( $_GET['user_identity'] ) ) && !isset( $_POST['updateProfileBtn'] ) ) {

		if ( isset( $_GET['user_identity'] ) ) {

			$url_encoded_id = $_GET['user_identity'];
			$decode_id = base64_decode( $url_encoded_id );
			$user_id_array = explode( "encodeuserid", $decode_id );
			$id = $user_id_array[1];

		}else {

			$id = $_SESSION['id'];

		}

		$sqlQuery = "SELECT * FROM users WHERE ID = :id";
		$statement = $conn->prepare( $sqlQuery );
		$statement->execute( array( ':id' => $id ) );

		while ( $rs = $statement->fetch() ) {

			$username = $rs['username'];
			$email = $rs['email'];
			$date_joined = strftime( "%b %d, %Y", strtotime( $rs['join_date'] ) );

		}

		$user_pic = "uploads/".$username.".jpg";
		$default = "uploads/default.jpg";

		if ( file_exists( $user_pic ) ) {
			$profile_picture = $user_pic;
		}else{
			$profile_picture = $default;
		}

		$encode_id = base64_encode( "encodeuserid{$id}" );

	}else if ( isset( $_POST['updateProfileBtn'] ) ) {

		$form_errors = array();
		$required_fields = array( 'email', 'username' );
		$form_errors = array_merge( $form_errors, check_empty_fields( $required_fields ) );
		$fields_to_check_length = array( 'username' => 4 );
		$form_errors = array_merge( $form_errors, check_min_length( $fields_to_check_length ) );
		$form_errors = array_merge( $form_errors, check_email( $_POST ) );

		// validate if file has a valid extension
		isset( $_FILES['avatar']['name'] ) ? $avatar = $_FILES['avatar']['name'] : $avatar = null;

		if ( $avatar != null ) {
			$form_errors = array_merge( $form_errors, isValidImage( $avatar ) );
		}

		$email = $_POST['email'];
		$username = $_POST['username'];
		$hidden_id = $_POST['hidden_id'];
		$profile_img_temp = $_FILES['avatar']['tmp_name'];

		move_uploaded_file( $profile_img_temp, "uploads/".$username.".jpg" );

		if ( empty( $form_errors ) ) {

			try {

				$sqlUpdate = "UPDATE users SET username = :username, email =:email WHERE id =:id";

				$statement = $conn->prepare($sqlUpdate);
				$statement->execute( array( ':username' => $username, ':email' => $email, ':id' => $hidden_id ) );

				if ( $statement->rowCount() == 1 ) {

					$result = "<script type=\"text/javascript\">
								swal({   
										title: \"Updated\",   
										text: \"Profile Update Successfully\",   
										type: 'success'
									});		
							</script>";

				}else {
					$result = "<script type=\"text/javascript\">
								swal( \"Nothing Happend!\", \"You have not made any changes.\");		
							</script>";
				}

			}catch ( PDOException $ex ) {

				$result = flashMessage( "An error occurred in : " .$ex->getMessage() );

			}

		}
		else {

			if ( count( $form_errors ) == 1 ) {

				$result = flashMessage( "There was 1 error in the form" );

			}else {

				$result = flashMessage( "There were " .count( $form_errors ). " errors in the form." );

			}

		}

	}

?>