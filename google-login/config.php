<?php
	session_start();
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId(getenv("GOOGLE_APP_ID");
	$gClient->setClientSecret(getenv("GOOGLE_APP_SECRET"));
	$gClient->setApplicationName(getenv("APP_NAME"));
	$gClient->setRedirectUri(getenv("REDIRECT_URI"));
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>
