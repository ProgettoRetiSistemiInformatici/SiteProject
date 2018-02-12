<?php
	session_start();

	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId("898494140533-eff6egnn3er9sj3fufji274r5ffuondr.apps.googleusercontent.com");
	$gClient->setClientSecret("iSSuOApVCA-s4Kwq1giIQM5Q");
	$gClient->setApplicationName("photolio");
	$gClient->setRedirectUri("http://photolio.altervista.org/login/g-callback.php");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
	$loginURL = $gClient->createAuthUrl();

?>
