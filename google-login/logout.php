<?php
	require_once "config.php";

	if(isset($_SESSION['access_token'])){
		unset($_SESSION['access_token']);
		$gClient->revokeToken();
	}
	
	unset($_SESSION['utente']);

	session_destroy();

	header('Location: ../index.php');

	exit();
?>
