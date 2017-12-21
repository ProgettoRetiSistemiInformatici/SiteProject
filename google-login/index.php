<?php
  require '../initialization/dbconnection.php';

	session_start();

  global $mysqli;

  if (isset($_SESSION['access_token'])) {
      $user_id = $_SESSION['current_user'];
      $query = "SELECT id FROM login WHERE id='$user_id';";
      if($result= $mysqli->query($query)){
        header('Location: ../home.php?user=' . $user_id);
      }
	}
  elseif($_SESSION['FBID']){
    $user_id = $_SESSION['FBID'];
    $query = "SELECT id FROM login WHERE id='$user_id';";
    if($result= $mysqli->query($query)){
      header('Location: ../home.php?user=' . $user_id);
    }
  }
  else {
    header('Location: ../google-login/login.php');
		exit();
  }

?>
