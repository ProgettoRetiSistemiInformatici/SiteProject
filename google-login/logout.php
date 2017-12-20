<?php

	session_start();

	require_once "config.php";

	if(isset($_SESSION['access_token'])){
		unset($_SESSION['access_token']);
		$gClient->revokeToken();
	}

	$_SESSION['FBID'] = NULL;
  $_SESSION['FBFULLNAME'] = NULL;
  $_SESSION['FBEMAIL'] = NULL;

	unset($_SESSION['utente']);

	session_destroy();

	header('Location: ../index.php');

	exit();
?>
