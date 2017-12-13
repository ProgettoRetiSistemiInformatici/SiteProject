<?php
	session_start();
<<<<<<< HEAD
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId(getenv("GOOGLE_APP_ID"));
	$gClient->setClientSecret(getenv("GOOGLE_APP_SECRET"));
	$gClient->setApplicationName("Client web 1");
	$gClient->setRedirectUri("http://localhost:8000");
=======
	require_once "GoogleAPI/vendor/autoload.php";
	$gClient = new Google_Client();
	$gClient->setClientId(getenv("GOOGLE_APP_ID");
	$gClient->setClientSecret(getenv("GOOGLE_APP_SECRET"));
	$gClient->setApplicationName(getenv("APP_NAME"));
	$gClient->setRedirectUri(getenv("REDIRECT_URI"));
>>>>>>> c4e8eed04fa369e772f4e2be70136ba753273096
	$gClient->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>
