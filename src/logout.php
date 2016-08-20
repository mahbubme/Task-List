<?php 

	include_once 'includes/session.php';
	include_once 'includes/functions.php';

	session_destroy(); 
	redirectTo( 'index' );

?>