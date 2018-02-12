<?php
	require_once "config.php";
	require '../initialization/dbconnection.php';

    error_reporting(E_ALL);
	ini_set('display_errors', 1);

	if (isset($_SESSION['google_token']))
		$gClient->setAccessToken($_SESSION['google_token']);
	else if (isset($_GET['code'])) {
		$token = $gClient->fetchAccessTokenWithAuthCode($_GET['code']);
		$_SESSION['google_token'] = $token;
	}

	$oAuth = new Google_Service_Oauth2($gClient);
	$userData = $oAuth->userinfo_v2_me->get();
        global $mysqli;


	$email = $userData['email'];
    $email = filter_var($email,FILTER_SANITIZE_STRING);
	$Name = $userData['givenName'];
    $Lastname = $userData['familyName'];
	$password = rand(555555, 999999999);
	$password = hash('sha256', $password);//Creazione dell'hash

		$mysqli->real_escape_string($password);
        $mysqli->real_escape_string($email);
        $result = $mysqli->query("SELECT id, email FROM login WHERE email = '$email'");
        if(!$result->num_rows){
           $query1 = "INSERT INTO login (firstname, lastname, email, password) VALUES('$Name', '$Lastname', '$email', '$password');";
           if(!$mysqli->query($query1)){
                $error = "error in mysql!";
                die($mysqli->error);
            }
            $query = "SELECT id FROM login WHERE email = '$email';";
			if($result = $mysqli->query($query)){
				$_SESSION['current_user'] = $result->fetch_object()->id;
			}
         }
         else{
               $obj=$result->fetch_object();
               $_SESSION['current_user'] = $obj->id;
         }
        $mysqli->close();
        session_write_close();

        header('Location: ../home.php');
	exit();
?>
