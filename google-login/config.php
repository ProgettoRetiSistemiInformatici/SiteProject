<?php
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId(getenv("GOOGLE_APP_ID"));
	$gClient->setClientSecret(getenv("GOOGLE_APP_SECRET"));
	$gClient->setApplicationName("Client web 1");
	$gClient->setRedirectUri("http://localhost:8000");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>
