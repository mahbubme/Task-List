<?php 

include_once 'includes/database.php';

$table = "CREATE TABLE IF NOT EXISTS tasks
		  (
			id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
			user_id INT NOT NULL,
			name VARCHAR(35) NOT NULL,
			description VARCHAR(255) NOT NULL,
			status VARCHAR(25) DEFAULT 'Not Completed',
			created_at TIMESTAMP
		  )";

try{

	$conn->query($table);
	//echo "<br>Table created";

}catch ( PDOException $ex ) {

	echo "<br>An error occured ". $ex->getMessage();

}

?>