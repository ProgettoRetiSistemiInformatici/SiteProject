<?php

  require '../initialization/dbconnection.php';
  require_once "../google-login/config.php";

  //se non si e' loggati si viene reindirizzati nella pagina di registrazione/login
  if(!isset($_SESSION["current_user"])){
      header("Location: /index.php");
  }

  $id = $_POST['current_user'];

  $user = $_SESSION['current_user'];

  $query="DELETE FROM login WHERE id = $id;";

  if(!$mysqli->query($query)){
    die($mysqli->error);
  }

  if(isset($_SESSION['access_token'])){
  	unset($_SESSION['access_token']);
  	$gClient->revokeToken();
  }

  $_SESSION['FBID'] = NULL;
  $_SESSION['FBFULLNAME'] = NULL;
  $_SESSION['FBEMAIL'] = NULL;

  unset($_SESSION['current_user']);

  session_destroy();

  header('Location: ../index.php');

  exit();

?>
