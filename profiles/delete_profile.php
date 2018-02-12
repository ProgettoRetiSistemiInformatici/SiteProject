<?php

  require '../initialization/dbconnection.php';
  require_once "../login/config.php";

  //se non si e' loggati si viene reindirizzati nella pagina di registrazione/login
  if(!isset($_SESSION["current_user"])){
      header("Location: ../index.php");
  }

  $id = $_POST['current_user'];

  $query="DELETE FROM login WHERE id = $id;";

  if(!$result = $mysqli->query($query)){
    die($mysqli->error);
  }

  if(isset($_SESSION['google_token'])){
  	unset($_SESSION['google_token']);
  	$gClient->revokeToken();
  }

	if(isset($_SESSION['fb_access_token'])){
    	unset($_SESSION['fb_access_token']);
    }

  unset($_SESSION['current_user']);

  session_destroy();
  exit();

?>
