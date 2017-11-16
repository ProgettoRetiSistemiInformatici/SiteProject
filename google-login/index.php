<?php
        include("../dbconnection.php");
	session_start();
        global $mysqli;
	if (!isset($_SESSION['access_token'])) {
		header('Location: login.php');
		exit();
	}
        else {
            $user = $_SESSION['utente'];
            $query="select name from users where name='$user';";
            if($result= $mysqli->query($query)){
            header('Location: ../home.php?user'.$user);
            }
        }
?>
