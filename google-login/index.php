<?php
  require '../initialization/dbconnection.php';
  
	session_start();
        global $mysqli;
	if (!isset($_SESSION['access_token'])) {
		header('Location: ../google-login/login.php');
		exit();
	}
        else {
            $user = $_SESSION['utente'];
            $query="SELECT name FROM users WHERE name='$user';";
            if($result= $mysqli->query($query)){
            header('Location: ../home.php?user='.$user);
            }
        }
?>
