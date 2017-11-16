<?php
	session_start();
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId("YOUR_CLIENT_ID");
	$gClient->setClientSecret("YOUR_CLIENT_SECRET");
	$gClient->setApplicationName("YOUR_APPLICATION_NAME");
	$gClient->setRedirectUri("YOUR_REDIRECT_URI");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>
