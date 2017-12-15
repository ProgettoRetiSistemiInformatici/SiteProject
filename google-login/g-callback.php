<?php
	require_once "config.php";
	require '../initialization/dvconnnection.php';

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
	$gender = $userData['gender'];
        $gender = filter_var($gender,FILTER_SANITIZE_STRING);
	$Name = $userData['givenName'];
        $Lastname = $userData['familyName'];
        $mysqli->real_escape_string($email);
        $mysqli->real_escape_string($gender);
        $result = $mysqli->query("SELECT name,email FROM users WHERE email = '$email'");
        if(!$result->num_rows){
           $query1 = "INSERT INTO users(name, firstname, lastname, email, gender) VALUES('$Name','$Name','$Lastname','$email','$gender');";
           if(!$mysqli->query($query1)){
                die($mysqli->error);
                $error = "error in mysql!";
            }
           }
           else{
               $obj=$result->fetch_object();
               $_SESSION['utente'] = $obj->name;
           }
        $mysqli->close();
        session_write_close();

        header('Location: index.php?user='.$_SESSION['utente']);
	exit();
?>
