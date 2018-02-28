<?php
	session_start();

	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId("your client id");
	$gClient->setClientSecret("your client secret");
	$gClient->setApplicationName("your app name");
	$gClient->setRedirectUri("your redirect to site");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
	$loginURL = $gClient->createAuthUrl();

?>
