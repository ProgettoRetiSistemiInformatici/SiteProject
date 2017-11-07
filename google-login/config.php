<?php
	session_start();
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId("940202534728-r2pmss81add0n9c5mpf4q4ip2bsca96n.apps.googleusercontent.com");
	$gClient->setClientSecret("G-ueTo6FANA4i-0oo-bsP0af");
	$gClient->setApplicationName("PRSI-Google-Oauth");
	$gClient->setRedirectUri("http://localhost/google-login/g-callback.php");
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>
