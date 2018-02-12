<?php
	session_start();

	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId("APP-ID");
	$gClient->setClientSecret("APP-SECRET");
	$gClient->setApplicationName("photolio");
	$gClient->setRedirectUri("http://photolio.altervista.org/login/g-callback.php");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
	$loginURL = $gClient->createAuthUrl();

?>
