<?php
	require_once "config.php";
        include ("dbconnection.php");
        
        session_start();

	if (isset($_SESSION['access_token']))
		$gClient->setAccessToken($_SESSION['access_token']);
	else if (isset($_GET['code'])) {
		$token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
		$_SESSION['access_token'] = $token;
	} 

	$oAuth = new Google_Service_Oauth2($gClient);
	$userData = $oAuth->userinfo_v2_me->get();
        global $mysqli;
        
        
	$email = $userData['email'];
        $email = filter_var($email,FILTER_SANITIZE_STRING);
	$Name = $userData['givenName'];
        $mysqli->real_escape_string($email);
        $_SESSION['utente'] = $Name;
        $query ="INSERT INTO users(username, email) VALUES('$Name','$email');";
        if(!$mysqli->query($query)){
            die($mysqli->error); 
            echo $id;
        }
        $mysqli->close;
        session_write_close();
	header('Location: /home.php?g_user='.$Name);
	exit();
?>
