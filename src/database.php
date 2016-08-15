<?php 

// specify your data structure source name and database login credentials and optionally any other specific connection options

define( "DSN", "mysql:host=localhost;dbname=tasklist" );
define( "USERNAME", "root" );
define( "PASSWORD", "" );

$options = array( PDO::ATTR_PERSISTENT => true );

try{

	$conn = new PDO( DSN, USERNAME, PASSWORD, $options );

	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	echo "connection successfull";

}catch ( PDOException $ex ) {

	echo "A database error occurred ".$ex->getMessage();

}