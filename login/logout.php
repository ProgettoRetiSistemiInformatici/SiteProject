<?php

	session_start();

	require_once "config.php";

	if(isset($_SESSION['google_token'])){
		unset($_SESSION['google_token']);
		$gClient->revokeToken();
	}
	
	if(isset($_SESSION['fb_access_token'])){
		unset($_SESSION['fb_access_token']);
	}
    
	unset($_SESSION['current_user']);

	session_destroy();

	header('Location: ../index.php');

	exit();
?>
