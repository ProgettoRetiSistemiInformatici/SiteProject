<?php
  require '../initialization/dbconnection.php';

  $current_user = $_SESSION['current_user'];
  $photo_id = $_POST['photo_id'];

  $query = "INSERT INTO sharing(by_user_id, photo_id) VALUES ('$current_user', '$photo_id');";
  if(!$result = $mysqli->query($query)){
    echo $mysqli->error;
  }

  $mysqli->close();
?>
