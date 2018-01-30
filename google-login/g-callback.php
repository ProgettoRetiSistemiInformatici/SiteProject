<?php
	require_once "config.php";
	require '../initialization/dbconnection.php';

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
	$password = rand(555555, 999999999);
				$password = hash('sha256', $password);//Creazione dell'hash

				$mysqli->real_escape_string($password);
        $mysqli->real_escape_string($email);
        $mysqli->real_escape_string($gender);
        $result = $mysqli->query("SELECT id, email FROM login WHERE email = '$email'");
        if(!$result->num_rows){
           $query1 = "INSERT INTO login  (firstname, lastname, email, gender , password) VALUES($Name', '$Lastname', '$email', '$gender', '$password');";
           if(!$mysqli->query($query1)){
                die($mysqli->error);
                $error = "error in mysql!";
            }
           }
           else{
               $obj=$result->fetch_object();
               $_SESSION['current_user'] = $obj->id;
           }
        $mysqli->close();
        session_write_close();

        header('Location: index.php?user=' . $_SESSION['current_user']);
	exit();
?>
