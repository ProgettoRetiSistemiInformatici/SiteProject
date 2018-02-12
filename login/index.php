<?php
  require '../initialization/dbconnection.php';

	session_start();

  global $mysqli;

  if (isset($_SESSION['access_token'])) {
    header('Location: ../home.php');
	}
  elseif(isset($_SESSION['fb_access_token'])){
      header('Location: ../home.php');
  }
  else {
    header('Location: ../google-login/login.php');
		exit();
  }

?>
