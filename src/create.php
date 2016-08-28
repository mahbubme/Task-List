<?php 
	
	include_once 'includes/session.php';
	include_once 'includes/database.php';

	
	if ( isset( $_POST['name'] ) && isset( $_POST['description'] ) ) {

		$user_id = $_SESSION['id'];
		$name = $_POST['name'];
		$description = $_POST['description'];

		try{

			$createQuery = "INSERT INTO tasks(name, user_id, description, created_at)
							VALUES(:name, :user_id, :description, now() )";

			$statement = $conn->prepare($createQuery);
			$statement->execute( array( ":name" => $name, ":user_id" => $user_id, ":description" => $description ) );

			if ( $statement ) {

				echo "Record Inserted";

			}

		}catch ( PDOException $ex ) {

			echo "An error occured" .$ex->getMessage();

		}

	}

?>