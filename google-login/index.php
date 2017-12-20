<?php
  require '../initialization/dbconnection.php';

	session_start();

  global $mysqli;

  if (isset($_SESSION['access_token'])) {
      $user = $_SESSION['utente'];
      $query="SELECT name FROM users WHERE name='$user';";
      if($result= $mysqli->query($query)){
        header('Location: ../home.php?user='.$user);
      }
	}
  elseif($_SESSION['FBID']){
    $user = $_SESSION['FBID'];
    $query="SELECT name FROM users WHERE name='$user';";
    if($result= $mysqli->query($query)){
      header('Location: ../home.php?user='.$user);
    }
  }
  else {
    header('Location: ../google-login/login.php');
		exit();
  }

?>
