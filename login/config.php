<?php
	session_start();

	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId("YOUR CLIENT ID");
	$gClient->setClientSecret("YOUR CLIENT SECRET");
	$gClient->setApplicationName("YOUR APP NAME");
	$gClient->setRedirectUri("YOUR GOOGLE CALLBACK DIRECTORY");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
	$loginURL = $gClient->createAuthUrl();

?>
