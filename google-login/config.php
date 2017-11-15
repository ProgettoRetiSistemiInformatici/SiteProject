<?php
	session_start();
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId(getenv("GOOGLE_APP_ID"));
	$gClient->setClientSecret(getenv("GOOGLE_APP_SECRET"));
	$gClient->setApplicationName("Client web 1");
	$gClient->setRedirectUri("http://lop.it");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>
