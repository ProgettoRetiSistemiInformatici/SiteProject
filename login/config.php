<?php
	session_start();

	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId("940202534728-r2pmss81add0n9c5mpf4q4ip2bsca96n.apps.googleusercontent.com");
	$gClient->setClientSecret("xGqENpKHcXkP2msAfa1TjDCc");
	$gClient->setApplicationName("PRSI-Google-Oauth");
	$gClient->setRedirectUri("http://photolio.com/login/g-callback.php");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
	$loginURL = $gClient->createAuthUrl();

?>
