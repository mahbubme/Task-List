<?php 
	
	include_once 'includes/database.php';
	include_once 'includes/functions.php';


	// delete the deactivate user permanently after 14 days
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
				$conn->exec( "DELETE FROM tasks WHERE user_id = $id" );
				$result = $conn->exec( "DELETE FROM users WHERE id = $id AND activated = '0' LIMIT 1" );

				//echo "$result Account deleted";

			}

		}
		
	} catch ( PDOException $ex ) {
		
		//$ex->getMessage();

	}

	// delete the non-activated user accounts 3 days after signup
	try {
		
		$query = $conn->query( "SELECT id, username FROM users WHERE join_date <= CURRENT_DATE - INTERVAL 3 DAY  AND activated = '0'" );

		while ( $rs = $query->fetch() ) {
			
			$user_id = $rs['id'];
			$username = $rs['username'];

			// check if a row exit in trash table
			if ( !checkDuplicateEntries( 'trash', 'user_id', $user_id, $conn ) ) {
				
				$user_pic = "uploads/".$username.".jpg";

				if ( file_exists( $user_pic ) ) {
					
					unlink( $user_pic );

				}

				$result = $conn->exec( "DELETE FROM users WHERE id= $user_id AND activated = '0' LIMIT 1" );
				//echo "$result Account deleted";

			}

		}

	} catch (PDOException $e) {
		
		//$ex->getMessage();

	}

?>