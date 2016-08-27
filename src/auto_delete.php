<?php 
	
	include_once 'includes/database.php';

	try {
		
		$sqlQuery = $conn->query( "SELECT user_id FROM trash WHERE deleted_at <= CURRENT_DATE - INTERVAL 14 DAY" );

		while ( $rs = $sqlQuery->fetch() ) {

			$user_id = $rs['user_id'];

			$userRecord = $conn->prepare( "SELECT * FROM users WHERE id = :id" );
			$userRecord->execute( array( ':id' => $user_id ) );

			if ( $row = $userRecord->fetch() ) {
				
				$username = $row['username'];
				$id = $row['id'];
				$user_pic = "uploads/".$username.".jpg";

				if ( file_exists( $user_pic ) ) {
					
					unlink( $user_pic );

				}

				$conn->exec( "DELETE FROM trash WHERE user_id = $id LIMIT 1" );
				$result = $conn->exec( "DELETE FROM users WHERE id = $id AND activated = '0' LIMIT 1" );

				//echo "$result Account deleted";

			}

		}
		
	} catch ( PDOException $ex ) {
		
		//$ex->getMessage();

	}

?>