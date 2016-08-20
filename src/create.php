<?php 

	include_once 'includes/database.php';

	
	if ( isset( $_POST['name'] ) && isset( $_POST['description'] ) ) {

		$name = $_POST['name'];
		$description = $_POST['description'];

		try{

			$createQuery = "INSERT INTO tasks(name, description, created_at)
							VALUES(:name, :description, now() )";

			$statement = $conn->prepare($createQuery);
			$statement->execute( array( ":name" => $name, ":description" => $description ) );

			if ( $statement ) {

				echo "Record Inserted";

			}

		}catch ( PDOException $ex ) {

			echo "An error occured" .$ex->getMessage();

		}

	}

?>